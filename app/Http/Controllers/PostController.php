<?php

namespace App\Http\Controllers;

use App\Post;
use Illuminate\Http\Request;

use App\Http\Resources\PostResource;

class PostController extends Controller
{
    /**
     * Requires endpoints, aside from those excepted, to user authentication
     */
    public function __construct()
    {
        $this->middleware('auth:api')
        ->except([
            'index',
            'show',
        ]);
    }
    
    /**
     * Convert payload to json
     * 
     * @param Mixed $payload data that can be converted to a json object
     * @return Response a json response
     */
    private function jsonResponse($payload)
    {
        return response()->json($payload);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $this->jsonResponse(
            PostResource::collection(Post::with('users')->paginate(10))
        );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    // public function create()
    // {
    //     //
    // }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $post = Post::create([
            'title' => $request->title,
            'excerpt' => $request->excerpt,
            'content' => $request->content,
            'featured_image' => $request->featured_image,
            'category' => $request->category,
            'tag' => $request->tag,
            'status' => $request->status,
            'scheduled_at' => $request->scheduled_at,
        ]);

        $post->users()->attach($request->user()->id);

        return $this->jsonResponse(new PostResource($post));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        return $this->jsonResponse(new PostResource($post));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    // public function edit(Post $post)
    // {
    //     //
    // }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        $post->delete();

        return response()->json(null, 204);
    }
}
