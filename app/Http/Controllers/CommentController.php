<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCommentRequest;
use App\Models\Post;
use Illuminate\Http\RedirectResponse;

class CommentController extends Controller
{
    public function store(StoreCommentRequest $request, string $slug): RedirectResponse
    {
        $post = Post::where('slug', $slug)->firstOrFail();

        $post->comments()->create($request->validated());

        return redirect()
            ->route('posts.show', $post->slug)
            ->with('success', 'Komentarz został dodany.')
            ->withFragment('comments');
    }
}
