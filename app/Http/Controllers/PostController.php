<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\AdminUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Resources\PostResource;
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
        return response()->json([
            'success' => true,
            'statusCode' => 200,
            'message' => 'Query success.',
            'data' => $post_arr
        ], 200);
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
            'success' => true,
            'statusCode' => 201,
            'message' => 'Post created.',
            'data' => [
                'post_id' => $Post->id,
            ]
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
        $response = [
            'success' => true,
            'statusCode' => 200,
            'message' => 'Query success.',
            'data' => new PostDataResource($post)
        ];

        $userPosts = $post->user->posts->sortByDesc('created_at')->values();

        $index = array_search($post->id, $userPosts->map->id->toArray());

        $response['previous'] = ($index !== 0) ? new PostResource($userPosts->slice($index - 1, 1)->first()) : null;

        $next = $userPosts->slice($index + 1, 1)->first();
        $response['next'] = ($next) ? new PostResource($next) : null;

        return response()->json($response, 200);
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
            'success' => true,
            'statusCode' => 200,
            'message' => 'Post updated',
            'data' => [
                'post_id' => $post->id,
            ]
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
        return response()->json([
            'success' => true,
            'statusCode' => 200,
            'message' => 'Post deleted.'
        ], 200);
    }

    public function getPost(Request $request, AdminUser $user)
    {
        return response()->json([
            'success' => true,
            'statusCode' => 200,
            'message' => 'Query success.',
            'data' => new AuthorPostsResource($user)
        ], 200);
    }
}
