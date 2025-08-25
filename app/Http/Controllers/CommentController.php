<?php

namespace App\Http\Controllers;

use App\Http\Resources\CommentResource;
use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Post $post)
    {
        $comments = $post->load('comments');

        return new CommentResource($comments);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Post $post)
    {
        Gate::authorize('create', Comment::class);

        $data = $request->validate([
            'comment' => 'required|string|min:10|max:1000'
        ]);

        $comment = $post->comments()->create([
            ...$data,
            'post_id' => $post->id,
            'user_id' => $request->user()->id
        ]);

        return new CommentResource($comment);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $post, Comment $comment)
    {
        Gate::authorize('update', $comment);

        $data = $request->validate([
            'comment' => 'required|string|min:10|max:1000'
        ]);

        $comment->update([
            ...$data,
            'post_id' => $post->id,
            'user_id' => $request->user()->id
        ]);

        return new CommentResource($comment);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post, Comment $comment)
    {
        Gate::authorize('delete', $comment);

        $comment->delete();

        return response()->json([
            'success' => 'comment is deleted'
        ]);
    }
}
