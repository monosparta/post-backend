<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\AdminUser;
use Illuminate\Http\Request;
use App\Http\Resources\PostDataResource;
use App\Http\Resources\AuthorPostsResource;
use Illuminate\Validation\ValidationException;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $Post = Post::orderBy('created_at', 'desc')->get();
        $post_arr = $Post->map(function ($item, $key) 
        {
            return new PostDataResource($item) ;
        });
        return response()->json($post_arr, 200);
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
        $request->validate([
            'title' => 'required|string',
            'content' => 'required|string',
            'user_id' => 'required|uuid'
        ]);
        $Post = Post::create($request->all());
        return response()->json([
            'post_id' => $Post->id,
            'message' => 'Successful Created'
            ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        return response()->json(new PostDataResource($post), 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post)
    {
        $post->update($request->all());
        return response()->json([
            'post_id' => $post->id,
            'message' => 'successful update'
            ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        $post->delete();
        return response()->json(['message' => 'Successful delete'], 200);
    }
    public function getPost(Request $request ,User $user)
    {
       return response()->json(new AuthorPostsResource($user));
    }
}
