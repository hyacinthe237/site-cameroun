<?php

namespace App\Http\Controllers\views\admin;

use Auth;
use Carbon\Carbon;
use App\Models\Post;
use App\Models\Category;
use App\Traits\SlugTrait;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class PostController extends Controller
{
    use SlugTrait;

    /**
     * list pages
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function index(Request $request)
    {
        try
        {
            $status = null;
            if ( $request->has('status') && $request->status != '' ) {
                if ( in_array($request->status, ['published', 'unpublished']) ) {
                    $status = $request->status;
                }
            }

            $keywords = $request->keywords;

            $posts = Post::with('category')
            ->when($keywords, function($query) use ($keywords) {
                return $query->where('title', 'rlike', $keywords);
            })
            ->when($status, function($query) use ($status) {
                return $query->where('status', $status);
            })
            ->orderBy('id', 'desc')
            ->paginate(50);

            $categories = Category::orderBy('name')->get();

            return view('admin.posts.index', ['posts' => $posts, 'categories' => $categories]);
        }
        catch (Exception $e) {
            return redirect()->back()->withErrors($e);
        }
    }



    /**
     * Create new page
     *
     * @return view()
     */
    public function create()
    {
        /*if ( Auth::user()->cant('create', Post::class))
        return redirect()->back()->withErrors(['authorization' => 'You are not authorized']);*/

        $categories = Category::orderBy('name')->get();

        return view('admin.posts.create', compact('categories'));
    }


    /**
     * Store a new page
     *
     * @param  Request $request
     *
     * @return redirect()
     */
    public function store(Request $request)
    {
        //dd($request->all());
        /*if ( Auth::user()->cant('create', Post::class))
        return redirect()->back()->withErrors(['authorization' => 'You are not authorized']);*/

        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'slug'  => 'required',
            'excerpt' => 'required'
        ]);

        if($validator->fails())
            return redirect()->back()->withErrors(['validator' => 'Title, slug & excerpts are required']);

        //Check if the slug exists using slug trait
        $slug = $this->getUniqueSlug($request->slug, 'posts');

        $post = Post::create([
            'title'             => $request->title,
            'slug'              => $slug,
            'tags'              => $request->tags ? $request->tags : 'xmd',
            'image'             => $request->image,
            'template'          => $request->template ? $request->template : 'default',
            'excerpt'           => $request->excerpt,
            'content'           => $request->contents,
            'status'            => $request->status,
            'category_id'       => $request->category_id,
            'last_updated_by'   => Auth::user()->id,
            'published_at'      => Carbon::now()
        ]);

        return redirect()->route('posts.index', ['id' => $post->id]);
    }




    /**
     * Display page for editing
     *
     * @param  integer $id page's id
     *
     * @return view()
     */
    public function edit($id)
    {
        /*if ( Auth::user()->cant('create', Post::class))
        return redirect()->back()->withErrors(['authorization' => 'You are not authorized']);*/

        $post = Post::find($id);
        //dd($post->status);
        if ( !$post ) return redirect()->route('post.index');
        $categories = Category::orderBy('name')->get();
        $cats = array();
        foreach ($categories as $category)
        {
            $cats[$category->id] = $category->name;
        }


        return view('admin.posts.edit', compact('post'))->withCategories($cats);
    }



    /**
     * Update a page
     * @param  Request $request [description]
     * @param  [type]  $id      [description]
     * @return [type]           [description]
     */
    public function update(Request $request, $id)
    {
        try
        {
            /*if ( Auth::user()->cant('create', Post::class))
            return redirect()->back()->withErrors(['authorization' => 'You are not authorized']);*/

            $validator = Validator::make($request->all(), [
                'title' => 'required'
            ]);

            if($validator->fails())
                return redirect()->back()->withErrors(['validator' => 'Title is required']);


            $post = Post::find($id);
            if ( !$post ) return redirect()->back();

            $post->tags             = $request->tags;
            $post->title            = $request->title;
            $post->image            = $request->image;
            $post->status           = $request->status;
            $post->template         = $request->template;
            $post->excerpt          = $request->excerpt;
            $post->content          = $request->content;
            $post->category_id      = $request->category_id;
            $post->template         = 'default';
            $post->last_updated_by  = Auth::user()->id;
            $post->save();

            return redirect()->back()->with('message', 'Post successfully update!');
        }
        catch (Exception $e) {
            return redirect()->back()->withErrors($e);
        }

    }

    public function destroy($id)
    {
        $post = Post::find($id);
        $post->delete();
        return redirect()->route('posts.index')->with('message', 'Post successfully deleted');
    }

}
