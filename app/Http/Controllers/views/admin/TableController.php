<?php

namespace App\Http\Controllers\views\admin;

use Auth;
use Carbon\Carbon;
use App\Models\Table;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;

class TableController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
    public function index(Request $request) {
        $tables = Table::get();

        return view('admin.tables.index', compact('tables'));
    }

    public function edit ($id)
    {
        $table  = Table::find($id);
        if (!$table)
            return redirect()->route('tables.index');

        return view('admin.tables.edit', compact('table'));
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
            'name'    => 'required'
        ]);

        if ($validator->fails())
            return redirect()->back()
                  ->withInput($request->all())
                  ->withErrors(['validator' => 'Tous les champs sont obligatoires']);

        $existing = Table::whereName($request->name)->first();

        if (!$existing) {
            Table::create([
              'name'    => $request->name
            ]);

            return redirect()->route('tables.index')->with('message', 'table crée avec succès');
        }

        return redirect()->back()
            ->withInput($request->all())
            ->withErrors(['existing' => 'Table existante']);
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
            'name'    => 'required'
        ]);

        if ($validator->fails())
            return redirect()->back()
              ->withInput($request->all())
              ->withErrors(['validator' => 'Tous les champs sont obligatoires']);

        $table = Table::find($id);
        if (!$table) return redirect()->back()->withErrors(['Table' => 'Table inconnue!']);

        $table->name   = $request->has('name') ? $request->name : $phase->name;
        $table->update();

        return redirect()->route('tables.index')->with('message', 'table mise à jour avec succès');
    }

}
