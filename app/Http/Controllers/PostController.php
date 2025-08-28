<?php

namespace App\Http\Controllers;

use App\Http\Resources\PostResource;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
       $posts = Post::latest()->paginate();

        return PostResource::collection($posts);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Gate::authorize('create', Post::class);

        $data = $request->validate([
            'title' => 'required|string|min:10|max:255',
            'post_img' => 'required|image|mimes:jpg,png,jpeg,webp|max:200',
            'content' => 'required',
            'status' => 'required',
            'category_id' => 'required'
        ]);

        // upload the image in the storage public directory 
        $data['post_img'] = $request->file('post_img')->store('thumbnails');
        
        $post = Post::create([
            ...$data,
            'user_id' => $request->user()->id,
        ]);

        return new PostResource($post);

    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        return new PostResource($post);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $post)
    {
        Gate::authorize('update', $post);

        $data = $request->validate([
            'title' => 'required|string|min:10|max:255',
            'post_img' => 'sometimes|image|mimes:jpg,png,jpeg,webp|max:200',
            'content' => 'required',
            'status' => 'required',
            'category_id' => 'required'
        ]);

        if($request->hasFile('post_img')) {
            $data['post_img'] = $request->file('post_img')->store('thumbnails'); 
        }

        $post->update([
            ...$data,
            'user_id' => $request->user()->id
        ]);

        return new PostResource($post);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        Gate::authorize('delete', $post);

        $post->delete();

        return response()->json([
            'success' => 'post has been deleted successfully'
        ]);
    }
}
