<?php

namespace App\Http\Controllers\views\admin;

use Auth;
use DB;
use Carbon\Carbon;
use App\Models\Formation;
use App\Models\Formateur;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;

class FormateurController extends Controller
{

  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index(Request $request)
  {
      $keywords = $request->keywords;
      $formateurs = Formateur::when($keywords, function($query) use ($keywords) {
          return $query->where('firstname', 'like', '%'.$keywords.'%')
          ->orWhere('lastname', 'like', '%'.$keywords.'%');
      })
      ->orderBy('id', 'desc')
      ->paginate(self::BACKEND_PAGINATE);

      return view('admin.formateurs.index', compact('formateurs'));
  }

    public function create ()
    {
        $formations  = Formation::whereIsActive(1)->orderBy('id', 'desc')->get();

        return view('admin.formateurs.create', compact('formations'));
    }

    public function edit ($id)
    {
        $formateur  = Formateur::with('formations')->find($id);
        $formations  = Formation::whereIsActive(1)->orderBy('id', 'desc')->get();

        if (!$formateur)
            return redirect()->route('formateurs.index');

        return view('admin.formateurs.edit', compact('formateur', 'formations'));
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
            'formation_id'  => 'required',
            'firstname'     => 'required',
            'lastname'      => 'required',
            'qualification' => 'required'
        ]);

        if ($validator->fails())
            return redirect()->back()
                  ->withInput($request->all())
                  ->withErrors(['validator' => 'Tous les champs sont obligatoires']);

        $existingFormateur = Formateur::whereFirstname($request->firstname)->whereLastname($request->lastname)->first();
        $formation = Formation::find($request->formation_id);

        if (!$existingFormateur) {
            $formateur = Formateur::create([
              'firstname'      => $request->firstname,
              'lastname'       => $request->lastname,
              'qualification'  => $request->qualification
            ]);

            if ($formateur) {
                $formateur->formations()->attach($request->formation_id);
            }

            return redirect()->route('formateurs.edit', $formateur->id)
                            ->withSuccess("Formateur ajouté avec succès");
        }

        return redirect()->back()
            ->withInput($request->all())
            ->withErrors(['existing' => 'Ce formateur existe déjà']);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'firstname'     => 'required',
            'lastname'      => 'required',
            'qualification' => 'required'
        ]);

        if ($validator->fails())
            return redirect()->back()
                ->withInput($request->all())
                ->withErrors(['validator' => 'Tous les champs sont obligatoires']);

        $formateur = Formateur::find($id);
        if (!$formateur)
            return redirect()->back()->withErrors(['formateur' => 'Formateur inconnu!']);

        $formateur->firstname      = $request->has('firstname') ? $request->firstname : $formateur->firstname;
        $formateur->lastname       = $request->has('lastname') ? $request->lastname : $formateur->lastname;
        $formateur->qualification  = $request->has('qualification') ? $request->qualification : $formateur->qualification;
        $formateur->update();

        return redirect()->back()->with('message', 'Formateur mis à jour avec succès');
    }

    public function destroy ($id)
    {
        $formateur = Formateur::find($id);
        if (!$formateur)
            return redirect()->back()->withErrors(['message' => 'formateur non existant']);

        DB::table('formateur_formations')::whereFormateurId($formateur->id)->delete();
        $formateur->delete();

        return redirect()->route('formateurs.index')->with('message', 'Formateur supprimé');
    }

    public function removeThematique ($id)
    {
        $ft = FormateurThematique::find($id);
        if (!$ft)
            return redirect()->back()->withErrors(['message' => 'Thématique non existante']);


        $formateur = Formateur::find($ft->formateur_id);
        $ft->delete();

        return redirect()->route('formateurs.edit', $formateur->id)->with('message', 'Thématique supprimée');
    }

    public function removeFormation ($id)
    {
        $ft = DB::table('formateur_formations')::find($id);
        if (!$ft)
            return redirect()->back()->withErrors(['message' => 'Formation non existante']);


        $formateur = Formateur::find($ft->formateur_id);
        $ft->delete();

        return redirect()->route('formateurs.edit', $formateur->id)->with('message', 'Formation supprimée');
    }

     /**
      * Store a newly created site formation in storage.
      *
      * @param  \Illuminate\Http\Request  $request
      * @return \Illuminate\Http\Response
      */
      public function storeFormation(Request $request, $id) {
          $validator = Validator::make($request->all(), [
              'formation_id' => 'required',
          ]);

          if ($validator->fails())
              return redirect()->back()
                 ->withInput($request->all())
                 ->withErrors(['validator' => 'Le champ formation est obligatoire']);

          $formateur = Formateur::find($id);
          if (!$formateur)
              return redirect()->back()->withInput($request->all())->withErrors(['validator' => 'Formateur inconnu']);

          $ft = DB::table('formateur_formations')->where('formateur_id', $formateur->id)
                ->where('formation_id', $request->formation_id)->first();
          if (!$ft) {
            DB::table('formateur_formations')->insert([
                'formateur_id' => $formateur->id,
                'formation_id' => $request->formation_id
            ]);

            return redirect()->back()->with('message', 'Formation du formateur ajoutée avec succès');
          } else {

            $ft->formateur_id  = $formateur->id;
            $ft->formation_id = $request->formation_id;
            $ft->update();

            return redirect()->back()->with('message', 'Formation du formateur modifiée avec succès');
          }
      }

     /**
      * Editer formation d'un formateur
      *
      * @param  int  $id
      * @return \Illuminate\Http\Response
      */
      public function editFormation ($id) {
          $formateur_formation = DB::table('formateur_formations')::with('formateur', 'formation')->find($id);
          if (!$formateur_formation)
              return redirect()->back()->withErrors(['status' => 'Formation inconnue']);

          $formations = Formation::whereIsActive(true)->get();

          return view('admin.formateurs.edit-formation', compact('formateur_formation', 'formations'));
      }

}
