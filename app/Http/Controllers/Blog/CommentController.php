<?php

namespace App\Http\Controllers\Blog;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Auth;

use App\Http\Requests\StorePostComment;

use App\Models\PostComment;

class CommentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api')->except('store', 'allComments');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $comments = [];

        if (Auth::user()->isAdmin() || Auth::user()->isSuper()) {
            foreach (Auth::user()->organization->posts as $post) {
                array_push($comments, $post->comments()->with('post', 'post.user')->get());
            }
        } else {
            foreach (Auth::user()->posts as $post) {
                array_push($comments, $post->comments()->with('post', 'post.user')->get());
            }
        }

        $comments = collect($comments)->collapse();

        return response($comments, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePostComment $request)
    {
        $validated = $request->validated();

        $comment = new PostComment();
        $comment->name = $request->name;
        $comment->email = $request->email;
        $comment->message = $request->message;
        $comment->post_id = $request->post_id;
        $comment->save();

        return response($comment, 200);
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
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->authorize('canWorkOnPost');
        
        $comment = PostComment::findOrFail($id);
        $comment->delete();

        return response([
            'message' => 'Success'
        ], 200);
    }

    /*
     * Display listing of verified comments for a particular post
    */
    public function allComments($id)
    {
        $comments = PostComment::where('post_id', $id)->latest()->get();

        return response($comments, 200);
    }
}
