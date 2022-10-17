<?php

namespace App\Http\Controllers;

use App\Http\Resources\AuthorPostsResource;
use App\Http\Resources\PostdataResource;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;

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
        $post_arr = $Post->map(function ($item, $key) {
            $User = User::where('id', $item->user_id)->firstOrFail();
            return [
                // 'id' => $item->id,
                // 'title' => $item->title,
                // 'content' => substr($item->content, 0, 300),
                // 'created_at' => $item->created_at,
                // 'updated_at' => $item->updated_at,
                // 'user' => [
                //     'id' => $User->id,
                //     'name' => $User->name
                // ]
                new PostdataResource($item)
            ];
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

        try {
            $validResult = $request->validate([
                "title" => "required|string",
                "content" => "required|string",
                'user_id' => 'required|uuid'
            ]);
            $Post = Post::create($request->all());
            $User = User::where('id', $request->input('user_id'))->firstOrFail();
            return response()->json([
                // 'id' => $Post->id,
                // 'title' => $Post->title,
                // 'content' => $Post->content,
                // 'created_at' => $Post->created_at,
                // 'updated_at' => $Post->updated_at,
                // 'user' => [
                //     'id' => $User->id,
                //     'name' => $User->name
                // ]
                new PostdataResource($Post)
            ], 201);
            //return response()->json($Post,201);
        } catch (ValidationException $exception) {
            $errorMessage =
                $exception->validator->getMessageBag()->getMessages();
            return response()->json(['message' => "incorrent format"], 400);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        //$User = User::where('id', $post->user_id)->firstOrFail();
        // return response()->json([
        //     'id' => $post->id,
        //     'title' => $post->title,
        //     'content' => $post->content,
        //     'created_at' => $post->created_at,
        //     'updated_at' => $post->updated_at,
        //     'user' => [
        //         'id' => $User->id,
        //         'name' => $User->name
        //     ]
        // ], 200);
        return response()->json(new PostdataResource($post), 200);
        // return response()->json($postId);
        // return response(['Message'=>'Post not found'], 404);
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
        $User = User::where('id', $post->user_id)->firstOrFail();
        $post->update($request->all());
        //return response($post);
        return response()->json([
            // 'id' => $post->id,
            // 'title' => $post->title,
            // 'content' => $post->content,
            // 'created_at' => $post->created_at,
            // 'updated_at' => $post->updated_at,
            // 'user' => [
            //     'id' => $User->id,
            //     'name' => $User->name
            // ]
            new PostdataResource($post)
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
        return response()->json(['message' => "Delete success"], 200);
    }
    public function getPost(Request $request){
        if($request->has('Id')){
            $authorId=$request->query('Id');
            //dd($authorId);
            $author = User::find($authorId);
            //dd($author);
            //return response($author);
            return response()->json(new AuthorPostsResource($author));
        }
        // return response()->json(Post::first()->user);
       // return response()->json(Post::with('user')->get());
    }
}
