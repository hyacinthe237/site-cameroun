<?php

namespace App\Http\Controllers\views\admin;

use Auth;
use DB;
use PDF;
use Carbon\Carbon;
use App\Models\Niveau;
use App\Models\Etudiant;
use App\Models\Formation;
use App\Models\Session;
use App\Helpers\EtudiantHelper;
use App\Repositories\EtudiantRepository as etudiantRepo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;

class EtudiantController extends Controller
{

  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index(Request $request, etudiantRepo $etudiantRepo) {
      $data = self::takeEtudiantInfos($request, $etudiantRepo);

      return view('admin.etudiants.index', compact('data'));
  }

    public function create () {
        $formations = Formation::get();
        $niveaux = Niveau::get();

        return view('admin.etudiants.create', compact('formations', 'niveaux'));
    }

    public function edit ($number)
    {
        $session = Session::whereStatus('pending')->first();
        $etudiant  = Etudiant::with('formations', 'niveau')->whereNumber($number)->first();

        if (!$etudiant)
            return redirect()->route('stagiaires.index');

        $formations = Formation::get();
        $niveaux = Niveau::get();

        return view('admin.etudiants.edit', compact('formations', 'niveaux', 'etudiant'));
    }

    public function inscrireEtudiant (Request $request, $number) {
       $etudiant  = Etudiant::whereNumber($number)->whereIsActive(true)->first();
       $session = Session::whereStatus('pending')->first();

       if (!$etudiant)
         return redirect()->back()->withErrors(['existing' => 'stagiaire non actif']);

         $form_etud = DB::table('formation_etudiants')->where('formation_id', $request->formation_id)
                      ->where('etudiant_id', $etudiant->id)->first();

         if (!$form_etud) {
            $etudiant->formations()->attach($request->formation_id);

             return redirect()->back()->with('message', 'etudiant ajoute a la formation');
         } else {
            $etudiant->formations()->detach($request->formation_id);
            return redirect()->back()->with('message', 'etudiant retire de la formation');
         }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'firstname' => 'required',
            'phone' => 'required',
        ]);

        if ($validator->fails()) {
          return redirect()->back()
                ->withInput($request->all())
                ->withErrors(['validator' => 'Les champs prénom et Telephone sont obligatoires']);
        }

        $session = Session::whereStatus('pending')->first();
        $existing = Etudiant::wherePhone($request->phone)->first();

        if (!$existing) {
            $etudiant = Etudiant::create([
              'number'          => EtudiantHelper::makeEtudiantNumber(),
              'niveau_id'       => $request->niveau_id,
              'firstname'       => $request->firstname,
              'lastname'        => $request->lastname,
              'phone'           => $request->phone,
              'email'           => $request->email,
              'sex'             => $request->sex,
              'dob'             => $request->dob,
            ]);

            $etudiant->formations()->attach($request->formation_id);

            return redirect()->route('stagiaires.edit', $etudiant->number)
                            ->with('message', "étudiant enregistré avec succès");
        } else {
          return redirect()->back()
                ->withInput($request->all())
                ->withErrors(['existing' => 'Un étudiant ayant un Téléphone identique a celui saisi a déjà été enregistré']);
        }

    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $number) {
        $validator = Validator::make($request->all(), [
            'firstname' => 'required',
            'phone' => 'required'
        ]);

        if ($validator->fails())
            return redirect()->back()->withInput($request->all())->withErrors(['validator' => 'Les champs Prénom & Telephone sont obligatoires']);

        $etudiant = Etudiant::whereNumber($number)->first();
        if (!$etudiant)
            return redirect()->back()->withErrors(['user' => 'Stagiaire inconnu!']);

        $etudiant->firstname         = $request->has('firstname') ? $request->firstname : $etudiant->firstname;
        $etudiant->lastname          = $request->has('lastname') ? $request->lastname : $etudiant->lastname;
        $etudiant->phone             = $request->has('phone') ? $request->phone : $etudiant->phone;
        $etudiant->email             = $request->has('email') ? $request->email : $etudiant->email;
        $etudiant->sex               = $request->has('sex') ? $request->sex : $etudiant->sex;
        $etudiant->dob               = $request->has('dob') ? $request->dob : $etudiant->dob;
        $etudiant->is_active         = $request->has('is_active') ? $request->is_active : $etudiant->is_active;
        $etudiant->niveau_id         = $request->has('niveau_id') ? $request->niveau_id : $etudiant->niveau_id;
        $etudiant->update();

        return redirect()->back()->with('message', 'Etudiant mis à jour avec succès');
    }

    public function desactivateOrActivate (Request $request, $number)
    {
        $etudiant = Etudiant::whereNumber($numer)->first();

        if (!$etudiant)
            return redirect()->back()->withErrors(['message' => 'Etudiant non existant']);

        if ($etudiant->is_active === 1) {
            $etudiant->is_active = false;
            $etudiant->save();

            return redirect()->back()->with('message', 'Etudiant désactivé');
        }

        if ($etudiant->is_active === 0) {
            $etudiant->is_active = true;
            $etudiant->save();

            return redirect()->back()->with('message', 'Etudiant activé');
        }
    }

    public function destroy ($id)
    {
        $etudiant = Etudiant::find($id);
        if (!$etudiant)
            return redirect()->back()->withErrors(['message' => 'Etudiant non existant']);

        $form_etud = DB::table('formation_etudiants')->where('etudiant_id', $etudiant->id)->get();
        if (sizeOf($form_etud)) {
            foreach ($form_etud as $item) {
                $item->delete();
            }
        }

        $etudiant->delete();

        return redirect()->route('stagiaires.index')->with('message', 'Etudiant supprimé');
    }

    /**
     * Download PDF Etudiant
     * @param  [type] $id [description]
     * @return [type]         [description]
     */
    public function downloadEtudiant (Request $request, etudiantRepo $etudiantRepo)
    {
        $data = self::takeEtudiantInfos($request, $etudiantRepo);

        $pdf = PDF::loadView('pdfs.etudiant', $data);
        return $pdf->stream();
    }

    /**
     * Recup Etudiant Information
     * @param  [type] $id [description]
     * @return [type]         [description]
     */
    private static function takeEtudiantInfos (Request $request, etudiantRepo $etudiantRepo)
    {
      $keywords = $request->keywords;
      $etudiants = Etudiant::with('formations', 'niveau')
          ->when($keywords, function($query) use ($keywords) {
              return $query->where('firstname', 'like', '%'.$keywords.'%')
                          ->orWhere('lastname', 'like', '%'.$keywords.'%');
          })
          ->when($request->formation, function ($q) use ($request) {
              return $q->whereHas('formations', function($sql) use ($request) {
                  return $sql->where('formation_id', $request->formation);
              });
          })
          ->when($request->niveau, function ($q) use ($request) {
              return $q->where('niveau_id', $request->niveau);
          })
          ->where('deleted_at', null)
          ->orderBy('lastname', 'asc')
          ->get();

        $formations = Formation::get();
        $niveaux = Niveau::get();
        $session = Session::whereStatus('pending')->first();

        $data = [
            'formations' => $formations,
            'etudiants' => $etudiants,
            'niveaux' => $niveaux,
            'keywords' => $keywords,
            'session' => $session,
        ];

        return $data;
    }

}
