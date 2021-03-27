<?php

namespace App\Http\Controllers\views\admin;

use Auth;
use DB;
use Carbon\Carbon;
use App\Models\Region;
use App\Traits\SlugTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;

class RegionController extends Controller
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
      $regions = Region::when($keywords, function($query) use ($keywords) {
          return $query->where('name', 'like', '%'.$keywords.'%');
      })
      ->orderBy('id', 'desc')
      ->get();

      return view('admin.regions.index-create', compact('regions'));
  }

    public function edit ($id)
    {
        $region  = Region::find($id);
        if (!$region)
            return redirect()->route('regions.index');

        return view('admin.regions.edit', compact('region'));
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
            'slug'     => 'required',
        ]);

        if ($validator->fails())
            return redirect()->back()
                  ->withInput($request->all())
                  ->withErrors(['validator' => 'Le champ Nom est obligatoire']);

        $existing = Region::whereName($request->name)->first();
        //Check if the slug exists using slug trait
        $slug = $this->getUniqueSlug($request->slug, 'regions');
        if (!$existing) {
            Region::create([
              'name'      => $request->name,
              'name'      => $request->name,
              'slug'      => $request->slug,
              'lon'      => $request->lon,
              'lat'      => $request->lat,
              'image' => $request->image,
            ]);

            return redirect()->back()->with('message', 'Région ajoutée avec succès');
        }

        return redirect()->back()
            ->withInput($request->all())
            ->withErrors(['existing' => 'Une Région sur ce nom a déjà été crée']);
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
            'slug'     => 'required',
        ]);

        if ($validator->fails())
            return redirect()->back()->withInput($request->all())->withErrors(['validator' => 'Le champ Nom est obligatoire']);

        $region = Region::find($id);
        if (!$region)
            return redirect()->back()->withErrors(['category' => 'Région inconnue']);

        $region->name = $request->has('name') ? $request->name : $region->name;
        $region->tags = $request->has('tags') ? $request->tags : $region->tags;
        $region->lon = $request->has('lon') ? $request->lon : $region->lon;
        $region->lat = $request->has('lat') ? $request->lat : $region->lat;
        $region->image = $request->has('image') ? $request->image : $region->image;
        $region->update();

        return redirect()->back()->with('message', 'Region mise à jour avec succès');
    }

}
