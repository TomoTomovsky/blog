<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePostReactionRequest;
use App\Models\Post;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index(Request $request)
    {
        $searchTerm = trim((string) $request->query('q', ''));

        $posts = Post::query()
            ->when($searchTerm !== '', function ($query) use ($searchTerm) {
                $query->where('title', 'like', "%{$searchTerm}%");
            })
            ->get();

        return view('posts.index', [
            'posts' => $posts,
        ]);
    }

    public function show(string $slug)
    {
        $post = Post::with([
            'comments' => fn ($query) => $query->latest(),
        ])->where('slug', $slug)->firstOrFail();

        return view('posts.show', [
            'post' => $post,
        ]);
    }

    public function create()
    {
        return view('posts.create');
    }

    public function random(): RedirectResponse
    {
        $post = Post::query()->inRandomOrder()->first();

        if (! $post) {
            return redirect()->route('posts.index');
        }

        return redirect()->route('posts.show', $post->slug);
    }

    public function store(Request $request)
    {
        $parameters = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'slug' => ['required', 'string', 'max:255', 'unique:posts,slug'],
            'lead' => ['nullable', 'string'],
            'author' => ['required', 'string', 'max:255'],
            'content' => ['required', 'string'],
        ]);

        $post = new Post;

        $post->title = $parameters['title'];
        $post->slug = $parameters['slug'];
        $post->lead = $parameters['lead'] ?? null;
        $post->author = $parameters['author'];
        $post->content = $parameters['content'];

        // Post::create($parameters);

        $post->save();

        return redirect()->route('posts.index');
    }

    public function react(StorePostReactionRequest $request, string $slug): RedirectResponse
    {
        $post = Post::where('slug', $slug)->firstOrFail();
        $reaction = $request->validated('reaction');
        $sessionKey = 'post_reactions';

        /** @var array<int, string> $sessionReactions */
        $sessionReactions = $request->session()->get($sessionKey, []);
        $previousReaction = $sessionReactions[$post->id] ?? null;

        if ($previousReaction === $reaction) {
            return redirect()->back();
        }

        if ($previousReaction === 'like' && $post->likes_count > 0) {
            $post->decrement('likes_count');
        }

        if ($previousReaction === 'dislike' && $post->dislikes_count > 0) {
            $post->decrement('dislikes_count');
        }

        if ($reaction === 'like') {
            $post->increment('likes_count');
        } else {
            $post->increment('dislikes_count');
        }

        $sessionReactions[$post->id] = $reaction;
        $request->session()->put($sessionKey, $sessionReactions);

        return redirect()->back();
    }
}
