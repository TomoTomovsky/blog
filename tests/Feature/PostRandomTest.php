<?php

use App\Models\Post;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('redirects to a random post when at least one post exists', function () {
    $post = Post::factory()->create([
        'slug' => 'only-post',
    ]);

    $this->get(route('posts.random'))
        ->assertRedirect(route('posts.show', $post->slug));
});

it('redirects back to index when no posts exist', function () {
    $this->get(route('posts.random'))
        ->assertRedirect(route('posts.index'));
});
