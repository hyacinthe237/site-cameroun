<?php

namespace App\Http\Controllers\views\admin;

use Auth;
use DB;
use Carbon\Carbon;
use App\Models\Niveau;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;

class NiveauController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index(Request $request)
  {
      $keywords = $request->keywords;
      $niveaux = Niveau::when($keywords, function($query) use ($keywords) {
          return $query->where('name', 'like', '%'.$keywords.'%');
      })
      ->orderBy('name', 'desc')
      ->paginate(self::BACKEND_PAGINATE);

      return view('admin.niveaux.index', compact('niveaux'));
  }

    public function create ()
    {
        return view('admin.niveaux.create');
    }

    public function edit ($id)
    {
        $niveau  = Niveau::find($id);
        if (!$niveau)
            return redirect()->route('niveaux.index');

        return view('admin.niveaux.edit', compact('niveau'));
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
            'name'     => 'required',
            'display_name'     => 'required'
        ]);

        if ($validator->fails())
            return redirect()->back()
                  ->withInput($request->all())
                  ->withErrors(['validator' => 'Tous les champs sont obligatoires']);

        $existing = Niveau::whereName($request->name)->first();

        if (!$existing) {
            Niveau::create([
              'name' => $request->name,
              'display_name' => $request->display_name
            ]);

            return redirect()->back()->with('message', 'Niveau ajouté avec succès');
        }

        return redirect()->back()->withErrors(['existing' => 'Niveau existant']);
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
            'name'     => 'required',
            'display_name'     => 'required'
        ]);

        if ($validator->fails())
            return redirect()->back()->withInput($request->all())->withErrors(['validator' => 'Tous les champs sont obligatoires']);

        $niveau = Niveau::find($id);
        if (!$niveau) {
            return redirect()->back()->withErrors(['phase' => 'niveau inconnu!']);
        }

        $niveau->name = $request->has('name') ? $request->name : $niveau->name;
        $niveau->display_name = $request->has('display_name') ? $request->display_name : $niveau->display_name;
        $niveau->update();

        return redirect()->back()->with('message', 'niveau mis à jour avec succès');
    }

    public function destroy ($id)
    {
        $niveau = Niveau::find($id);
        if (!$niveau)
            return redirect()->back()->withErrors(['message' => 'niveau non existant']);

        $niveau->delete();
        return redirect()->route('niveaux.index')->with('message', 'niveau supprimé');
    }

}
