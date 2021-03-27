<?php

namespace App\Http\Controllers\views\admin;

use App\Models\Category;
use App\Models\Post;
use App\Traits\SlugTrait;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{

    use SlugTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::paginate(20);
        return view('admin.categories.index-create', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
        ]);

        if ($validator->fails())
            return redirect()->back()->withErrors(['validator' => 'A category title is required']);

        $slug = $this->getUniqueSlug(strtolower($request->name), 'categories');

        Category::create(['name' => $request->name, 'slug' => $slug]);
        return redirect()->back()->with('message', 'Category successfully added');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $category = Category::findOrFail($id);
        return view('admin.categories.edit', compact('category'));

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
        ]);

        if($validator->fails())
            return redirect()->back()->withErrors(['validator' => 'Can\'t make name empty']);

        $category = Category::findOrFail($id);
        $category->name = $request->name;
        $category->update();

        return redirect()->back()->with('message', 'Category successfully updated');


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $check = Post::where('category_id', $id)->count();
        if ($check > 0)
            return back()->with('message', 'This category has associated posts! Please delete all post and try again.');

        Category::find($id)->delete();
        return redirect()->route('categories.index')->with('message', 'Category successfully deleted');

    }
}
