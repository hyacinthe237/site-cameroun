<?php

namespace App\Http\Controllers\views\admin;

use Auth;
use DB;
use Carbon\Carbon;
use App\Models\Table;
use App\Models\Billet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;

class BilletController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index(Request $request)
  {
      $keywords = $request->keywords;
      $billets = Billet::with('table')
      ->when($keywords, function($query) use ($keywords) {
          return $query->where('name', 'like', '%'.$keywords.'%');
      })
      ->when($request->table_id, function($query) use ($keywords) {
          return $query->where('table_id', $request->table_id);
      })
      ->orderBy('name', 'desc')
      ->get();
      $tables = Table::get();

      return view('admin.billets.index', compact('billets', 'tables'));
  }

    public function valid ($id)
    {
        $billet  = Billet::find($id);

        if ($billet) {
          if (!$billet->is_entered) {
            $billet->is_entered = true;
            $billet->save();

            return redirect()->back()->with('message', 'Bien vouloir conduire l\'invité sur sa table');
          } else {
            $billet->is_entered = false;
            $billet->save();

            return redirect()->back()->with('message', 'Invité est sortie');
          }
        }
    }

    public function edit ($id)
    {
        $billet  = Billet::find($id);
        $tables = Table::get();
        if (!$billet)
            return redirect()->route('billets.index');

        return view('admin.billets.edit', compact('billet', 'tables'));
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
            'name' => 'required',
            'code' => 'required',
        ]);

        if ($validator->fails())
            return redirect()->back()
                  ->withInput($request->all())
                  ->withErrors(['validator' => 'Tous les champs sont obligatoires']);

        $existing = Billet::whereCode($request->code)->first();

        if (!$existing) {
            Billet::create([
              'table_id' => $request->table_id,
              'name' => $request->name,
              'code' => $request->code,
              'type' => $request->type,
              'civilite' => $request->civilite,
            ]);

            return redirect()->back()->with('message', 'billet ajouté avec succès');
        }

        return redirect()->back()->withErrors(['existing' => 'billet existant']);
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
            'name' => 'required',
            'code' => 'required'
        ]);

        if ($validator->fails())
            return redirect()->back()->withInput($request->all())->withErrors(['validator' => 'Tous les champs sont obligatoires']);

        $billet = Billet::find($id);
        if (!$billet) {
            return redirect()->back()->withErrors(['phase' => 'billet inconnu!']);
        }

        $billet->table_id = $request->has('table_id') ? $request->table_id : $billet->table_id;
        $billet->name = $request->has('name') ? $request->name : $billet->name;
        $billet->type = $request->has('type') ? $request->type : $billet->type;
        $billet->civilite = $request->has('civilite') ? $request->civilite : $billet->civilite;
        $billet->update();

        return redirect()->back()->with('message', 'billet mis à jour avec succès');
    }

    public function destroy ($id)
    {
        $billet = Billet::find($id);
        if (!$billet)
            return redirect()->back()->withErrors(['message' => 'billet non existant']);

        $billet->delete();
        return redirect()->route('billets.index')->with('message', 'billet supprimé');
    }

}
