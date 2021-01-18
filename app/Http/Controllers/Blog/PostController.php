<?php

namespace App\Http\Controllers\Blog;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

use App\Models\Post;
use App\Models\Organization;

use App\Http\Requests\StorePost;

class PostController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api')->except('show', 'allPosts');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function allPosts($organization_id)
    {
        $posts = '';

        $organization = Organization::findOrFail($organization_id);

        $posts = $organization->posts()
            ->with('user')
            ->withCount('comments')
            ->where('status', 1)
            ->latest()
            ->paginate(3);

        return response($posts, 200);
    }

    /*
     * Display posts in dashboards
    */
    public function index()
    {
        if (Auth::user()->isAdmin() || Auth::user()->isSuper()) {
            $posts = Auth::user()->organization->posts()->with('user')->withCount('comments')->get();
        } else {
            $posts = Auth::user()->posts()->with('user')->withCount('comments')->get();
        }

        return response($posts, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePost $request)
    {
        $this->authorize('canWorkOnPost');

        $validated = $request->validated();

        $this->validate($request, [
            'featured_image' => 'required',
        ]);

        $post = new Post();
        $post->title = $request->title;
        $post->content = $request->content;
        $post->excerpt = $request->excerpt;
        $post->status = $request->status;

        if (!empty($request->featured_image)) {
            $file = str_replace(' ', '', str_replace('.', '', microtime())).'.'.explode('/', explode(':', substr($request->featured_image, 0, strpos($request->featured_image, ';')))[1])[1];
            \Image::make($request->featured_image)->save(public_path('images/posts/'.$file));
            $post->featured_image = $file;
        }

        if (Gate::denies('canControlOrganization')) {
            $post->verified = 0;
            $post->status = 0;
        }

        $post->user_id = $request->user()->id;
        $post->organization_id = $request->user()->organization->id;
        $post->save();

        return response($post, 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $post = Post::with('user')->withCount('comments')->findOrFail($id);

        return response($post, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StorePost $request, $id)
    {
        $this->authorize('canWorkOnPost');

        $post = Post::findOrFail($id);
        $post->title = $request->title;
        $post->content = $request->content;
        $post->excerpt = $request->excerpt;
        $post->status = $request->status;

        if ($request->featured_image && (strlen($request->featured_image) > 50)) {
            $image = 'images/posts/'.$post->featured_image;
            if (file_exists($image)) {
                @unlink($image);
            }

            $file = str_replace(' ', '', str_replace('.', '', microtime())).'.'.explode('/', explode(':', substr($request->featured_image, 0, strpos($request->featured_image, ';')))[1])[1];
            \Image::make($request->featured_image)->save(public_path('images/posts/'.$file));
            $post->featured_image = $file;
        }

        $post->save();

        return response($post, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post = Post::findOrFail($id);

        $this->authorize('canControlPost', $post);

        $post->delete();

        return response([
            'message' => 'Success'
        ], 200);
    }

    /*
     * Alter the verification of a post
    */
    public function alterVerification($id)
    {
        $this->authorize('canControlOrganization');

        $post = Post::findOrFail($id);

        if ($post->verified == 1) {
            $post->verified = 0;
            $post->status = 0;
        } else {
            $post->verified = 1;
            $post->status = 1;
        }

        $post->save();

        return response($post, 200);
    }

    /*
     * Alter the status of a post
    */
    public function alterVisibility($id)
    {
        $this->authorize('canControlOrganization');

        $post = Post::findOrFail($id);

        if ($post->status == 1) {
            $post->status = 0;
        } else {
            $post->verified = 1;
            $post->status = 1;
        }

        $post->save();

        return response($post, 200);
    }
}
