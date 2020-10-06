<?php

namespace App\Http\Controllers\views\admin;

use Auth;
use DB;
use PDF;
use Carbon\Carbon;
use App\Models\Etudiant;
use App\Models\Formation;
use App\Models\Session;
use App\Models\Category;
use App\Models\Formateur;
use App\Helpers\FormationHelper;
use App\Repositories\FormationRepository as formRepo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;

class FormationsController extends Controller
{
    private $formRepo;

    // model args
    public function __construct(formRepo $formRepo)
    {
        $this->formRepo = $formRepo;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
     public function index(Request $request) {
         $session = Session::whereStatus('pending')->first();
         $status = $request->is_active;
         $formations = Formation::with('etudiants', 'formateurs', 'category')
             ->when($request->keywords, function($query) use ($request) {
                 return $query->where('title', 'like', '%'.$request->keywords.'%');
             })
             ->when($status, function($query) use ($status) {
                 return $query->where('is_active', $status);
             })
             ->when($request->category, function($query) use ($request) {
                 return $query->where('category_id', $request->category_id);
             })
             ->whereSessionId($session->id)
             ->orderBy('id', 'desc')
             ->paginate(self::BACKEND_PAGINATE);

             $categories = Category::get();
         return view('admin.formations.index', compact('formations', 'categories'));
     }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
     public function create () {
         $categories = Category::orderBy('name')->get();

         return view('admin.formations.create', compact('categories'));
     }

    /**
     * Store a newly created formation in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
     public function store(Request $request) {
         $validator = Validator::make($request->all(), [
             'title'      => 'required'
         ]);

         if ($validator->fails())
             return redirect()->back()
                ->withInput($request->all())
                ->withErrors(['validator' => 'Le champ Titre est obligatoire']);

         $session = Session::whereStatus('pending')->first();
         $existing = Formation::whereTitle($request->title)->first();

         $debut = $request->start_date .' '. $request->start_heure.':'.$request->start_minutes;
         $fin = $request->end_date .' '. $request->end_heure.':'.$request->end_minutes;
         $start_date = Carbon::parse($debut)->format('Y-m-d H:i');
         $end_date = Carbon::parse($fin)->format('Y-m-d H:i');

         if (!$existing) {
             $formation = Formation::create([
               'number'      => FormationHelper::makeFormationNumber(),
               'session_id'  => $session->id,
               'category_id' => $request->category_id,
               'title'       => $request->title,
               'description' => $request->description,
               'is_active'   => $request->is_active,
               'start_date'  => $start_date,
               'end_date'    => $end_date
             ]);

             return redirect()->route('formation.edit', $formation->number)
                        ->with('message', 'Formation ajoutée avec succès');
         }

         return redirect()->back()
              ->withInput($request->all())
              ->withErrors(['existing' => 'Cette Formation existe déjà']);
     }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($number) {
      $formation  = Formation::whereNumber($number)->first();
      if (!$formation)
          return redirect()->route('formations.index');

      return view('admin.formations.show', compact('formation'));
    }

    /**
     * Editer une formation.
     *
     * @param  int  $number
     * @return \Illuminate\Http\Response
     */
     public function edit ($number) {
         $formation  = Formation::whereNumber($number)->with('etudiants', 'formateurs')->first();
         if (!$formation)
             return redirect()->route('formation.edit', $formation->number);

         $categories = Category::orderBy('name', 'asc')->get();
         $formateurs = Formateur::get();
         $etudiants = Etudiant::whereIsActive(true)->get();

         return view('admin.formations.edit', compact('categories', 'formation', 'formateurs', 'etudiants'));
     }

     /**
      * Ajouter un etudiant a une formation
      *
      * @param  int  $number
      * @return \Illuminate\Http\Response
      */
     public function ajouterEtudiant (Request $request, $id) {
        $session = Session::whereStatus('pending')->first();
        $formation  = Formation::whereSessionId($session->id)->find($id);
        $etudiant  = Etudiant::whereIsActive(true)->find($request->etudiant_id);

        if (!$formation)
          return redirect()->back()->withErrors(['existing' => 'Formation non active']);

        if (!$etudiant)
          return redirect()->back()->withErrors(['existing' => 'Etudiant non actif']);

          $form_etud = DB::table('formation_etudiants')->where('etudiant_id', '=', $etudiant->id)
                       ->where('formation_id', '=', $formation->id)
                       ->first();

          $count = DB::table('formation_etudiants')->where('formation_id', '=', $formation->id)->count();

          if (!$form_etud && ($count <= $formation->places)) {
              $formation->etudiants()->attach($etudiant->id);

              return redirect()->back()->with('message', 'Etudiant ajouté avec succès à la formation');
          } else {
             return redirect()->back()->withErrors(['existing' => "Nombre requis de la formation est atteind ou Vous voulez inscrire l'étudiant à formation qui suit déjà"]);
          }
     }

    /**
     * Update Une formation.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
     public function update(Request $request, $number) {

         $validator = Validator::make($request->all(), [
             'title'      => 'required'
         ]);

         if ($validator->fails())
             return redirect()->back()
                ->withInput($request->all())
                ->withErrors(['validator' => 'Le champ Titre est obligatoire']);

         $formation = Formation::whereNumber($number)->first();
         if (!$formation)
             return redirect()->back()->withErrors(['user' => 'Formation inconnue!']);

         $debut = $request->start_date .' '. $request->start_heure.':'.$request->start_minutes;
         $fin = $request->end_date .' '. $request->end_heure.':'.$request->end_minutes;
         $start_date = Carbon::parse($debut)->format('Y-m-d H:i');
         $end_date = Carbon::parse($fin)->format('Y-m-d H:i');

         $formation->title        = $request->has('title') ? $request->title : $formation->title;
         $formation->description  = $request->has('description') ? $request->description : $formation->description;
         $formation->is_active    = $request->has('is_active') ? $request->is_active : $formation->is_active;
         $formation->category_id  = $request->has('category_id') ? $request->category_id : $formation->category_id;
         $formation->start_date   = $request->has('start_date') ? $start_date : $formation->start_date;
         $formation->end_date     = $request->has('end_date') ? $end_date : $formation->end_date;
         $formation->update();

         // $formation->formateurs()->sync($request->financeurs);

         return redirect()->back()->with('message', 'Formation mise à jour avec succès');
     }

     public function desactivateOrActivate ($number) {
         $formation = Formation::whereNumber($numer)->first();

         if (!$formation)
             return redirect()->back()->withErrors(['message' => 'Formation non existante']);

         if ($formation->is_active === 1) {
             $formation->is_active = false;
             $formation->save();

             return redirect()->back()->with('message', 'Formation désactivée');
         }

         if ($formation->is_active === 0) {
             $formation->is_active = true;
             $formation->save();

             return redirect()->back()->with('message', 'Formation activée');
         }
     }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
     public function destroy ($id) {
         $formation = Formation::find($id);
         if (!$formation)
             return redirect()->back()->withErrors(['message' => 'Formation non existante']);

         $formation_etudiants = DB::table('formation_etudiants')->where('formation_id', $formation->id)->get();
         $formateur_formations = DB::table('formateur_formations')->where('formation_id', $formation->id)->get();
         if ($formation_etudiants) {
            $formation_etudiants->delete();
         }

         if ($formateur_formations) {
            $formateur_formations->delete();
         }

         $formation->delete();
         return redirect()->route('formation.index')->with('message', 'Formation supprimée');
     }

     /**
      * Download PDF Formation
      * @param  [type] $id [description]
      * @return [type]         [description]
      */
     public function downloadFormation (formRepo $formRepo)
     {
         $data = self::takeFormationInfos($formRepo);

         $pdf = PDF::loadView('pdfs.formation', $data);
         return $pdf->stream();
     }

     /**
      * Recup Formation Information
      * @param  [type] $id [description]
      * @return [type]         [description]
      */
     private static function takeFormationInfos ($formRepo)
     {
         $formations = Formation::with('etudiants', 'formateurs', 'category')->whereIsActive(true)->get();
         $data = [
             'formations' => $formations
         ];

         return $data;
     }
}
