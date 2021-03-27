<?php

namespace App\Http\Controllers\views\admin;

use Auth;
use DB;
use Carbon\Carbon;
use App\Models\Departement;
use App\Models\Region;
use App\Traits\SlugTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;

class DepartementController extends Controller
{
  use SlugTrait;

  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index(Request $request)
  {
      $keywords = $request->keywords;
      $region = $request->region;
      $departements = Departement::when($keywords, function($query) use ($keywords) {
          return $query->where('name', 'like', '%'.$keywords.'%');
      })
      ->when($region, function($query) use ($region) {
          return $query->where('region_id', $region);
      })
      ->orderBy('id', 'desc')
      ->get();

      $regions = Region::get();

      return view('admin.departements.index-create', compact('departements', 'regions'));
  }

    public function edit ($id)
    {
        $departement  = Departement::find($id);
        $regions = Region::get();
        if (!$departement)
            return redirect()->route('departements.index');

        return view('admin.departements.edit', compact('departement', 'regions'));
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
            'slug'     => 'required'
        ]);

        if ($validator->fails())
            return redirect()->back()
                  ->withInput($request->all())
                  ->withErrors(['validator' => 'Le champ Nom est obligatoire']);

        $existing = Departement::whereName($request->name)->first();
        //Check if the slug exists using slug trait
        $slug = $this->getUniqueSlug($request->slug, 'departements');
        if (!$existing) {
            Departement::create([
              'region_id' => $request->region_id,
              'name'      => $request->name,
              'slug'      => $slug,
              'tags'      => $request->tags,
              'lon'      => $request->lon,
              'lat'      => $request->lat,
              'image'      => $request->image,
            ]);

            return redirect()->back()->with('message', 'Département ajouté avec succès');
        }

        return redirect()->back()
            ->withInput($request->all())
            ->withErrors(['existing' => 'Un Département sur ce nom a déjà été créé']);
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
            'name'     => 'required'
        ]);

        if ($validator->fails())
            return redirect()->back()->withInput($request->all())->withErrors(['validator' => 'Le champ Nom est obligatoire']);

        $departement = Departement::find($id);
        if (!$departement)
            return redirect()->back()->withErrors(['category' => 'Département inconnu!']);

        $departement->region_id = $request->has('region_id') ? $request->region_id : $departement->region_id;
        $departement->name = $request->has('name') ? $request->name : $departement->name;
        $departement->tags = $request->has('tags') ? $request->tags : $departement->tags;
        $departement->lon = $request->has('lon') ? $request->lon : $departement->lon;
        $departement->lat = $request->has('lat') ? $request->lat : $departement->lat;
        $departement->image = $request->has('image') ? $request->image : $departement->image;
        $departement->update();

        return redirect()->back()->with('message', 'Département mise à jour avec succès');
    }

}
