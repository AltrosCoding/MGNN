<?php

namespace App\Http\Controllers;

use App\Post;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
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

    private function isScheduling(Request $request): bool
    {
        return $request->has(['scheduled_at']);
    }

    private function isPublishing(Request $request): bool
    {
        return $request->has(['status']) && $request->status === 'published';
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
        $posts = Post::with('users');

        if (Auth::check()) {
            $client = Auth::user();
            
            if ($client->cannot('edit_article')) {
                $posts = $posts->where('status', '=', 'published');

                if ($client->can('view_pending')) {
                    $posts = $posts->orWhere('status', '=', 'scheduled')
                    ->orWhere('status', '=', 'pending');
                }

                if ($client->can('create_article')) {
                    $posts = $posts->orWhereHas('users', function ($query) use ($client) {
                        $query->where('id', '=', $client->id);
                    });
                }

                $posts = $posts->orderBy('created_at', 'desc');
            }

            $posts = $posts->orderBy('published_at', 'desc')
            ->orderBy('updated_at', 'desc');
        }
        else {
            $posts = $posts->where('status', '=', 'published')
            ->orderBy('published_at', 'desc');
        }

        return $this->jsonResponse(
            PostResource::collection($posts->paginate(10))
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if ($this->isScheduling($request) && $this->isPublishing($request)) {
            return response()->json([
                'error' => 'Bad Request',
            ], 400);
        }
        
        $client = $request->user();

        if ($client->cannot('create_article')) {
            return response()->json([
                'error' => 'Forbidden',
            ], 403);
        }

        if ($this->isScheduling($request)
        && $client->cannot('schedule_article')) {
            return response()->json([
                'error' => 'Forbidden',
            ], 403);
        }

        if ($this->isPublishing($request)
        && $client->cannot('publish_article')) {
            return response()->json([
                'error' => 'Forbidden',
            ], 403);
        }
        else if ($this->isPublishing($request)) {
            $request->request->add(['published_at' => \Carbon\Carbon::now()]);
        }

        $post = Post::create([
            'title' => $request->title,
            'excerpt' => $request->excerpt,
            'content' => $request->content,
            'featured_image' => $request->featured_image,
            'category' => $request->category,
            'tag' => $request->tag,
            'status' => $request->status,
            'published_at' => $request->published_at,
        ]);

        if (!$this->isPublishing($request) && $this->isScheduling($request)) {
            $post->schedule()->create([
                'scheduled_at' => $request->scheduled_at,
            ]);
        }

        $post->users()->attach($client->id);

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
        if ($post->status === 'published') {
            return $this->jsonResponse(new PostResource($post));
        }
        
        if (!Auth::check()) {
            return response()->json([
                'error' => 'Unauthorized',
            ], 401);
        }

        $client = Auth::user();

        if ($client->cannot('edit_article')) {
            if ($client->can('view_pending') 
                && ($post->status === 'scheduled' 
                || $post->status === 'pending')) {
                return $this->jsonResponse(new PostResource($post));
            }

            if ($client->can('create_article') && $post->users()->contains($client)) {
                return $this->jsonResponse(new PostResource($post));
            }

            return response()->json([
                'error' => 'Forbidden',
            ], 403);
        }

        return $this->jsonResponse(new PostResource($post));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post)
    {
        if ($this->isScheduling($request) && $this->isPublishing($request)) {
            return response()->json([
                'error' => 'Bad Request',
            ], 400);
        }

        $client = $request->user();

        if ($client->cannot('edit_article')
        && !$post->users()->contains($client)) {
            return response()->json([
                'error' => 'Forbidden',
            ], 403);
        }

        if ($request->has(['add_authors'])) {
            if ($client->cannot('invite_author')) {
                return response()->json([
                    'error' => 'Forbidden',
                ], 403);
            }

            $post->users()->syncWithoutDetaching($request->add_authors);
        }

        if ($request->has(['remove_authors'])) {
            if ($client->cannot('remove_author')) {
                return response()->json([
                    'error' => 'Forbidden',
                ], 403);
            }

            $post->users()->detach($request->remove_authors);
        }

        if ($this->isScheduling($request)
        && $client->cannot('schedule_article')) {
            return response()->json([
                'error' => 'Forbidden',
            ], 403);
        }

        if ($this->isPublishing($request)
        && $client->cannot('publish_article')) {
            return response()->json([
                'error' => 'Forbidden',
            ], 403);
        }
        else if ($this->isPublishing($request)) {
            $request->request->add(['published_at' => \Carbon\Carbon::now()]);
        }

        $post->update($request->only([
            'title',
            'excerpt',
            'content',
            'featured_image',
            'category',
            'tag',
            'status',
            'published_at',
        ]));

        if (!$this->isPublishing($request) && $this->isScheduling($request)) {
            $post->schedule()->create([
                'scheduled_at' => $request->scheduled_at,
            ]);
        }

        return $this->jsonResponse(new PostResource($post));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Post $post)
    {
        $client = $request->user();

        if ($client->cannot('delete_article')) {
            return response()->json([
                'error' => 'Forbidden',
            ], 403);
        }

        $post->delete();

        return response()->json(null, 204);
    }
}
