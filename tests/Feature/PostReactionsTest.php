<?php

use App\Models\Post;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('increments likes count for a post', function () {
    $post = Post::factory()->create([
        'slug' => 'like-post',
        'likes_count' => 0,
        'dislikes_count' => 0,
    ]);

    $this->from(route('posts.index'))
        ->post(route('posts.reactions.store', $post->slug), [
            'reaction' => 'like',
        ])
        ->assertRedirect(route('posts.index'));

    $post->refresh();

    expect($post->likes_count)->toBe(1)
        ->and($post->dislikes_count)->toBe(0);
});

it('increments dislikes count for a post', function () {
    $post = Post::factory()->create([
        'slug' => 'dislike-post',
        'likes_count' => 0,
        'dislikes_count' => 0,
    ]);

    $this->from(route('posts.index'))
        ->post(route('posts.reactions.store', $post->slug), [
            'reaction' => 'dislike',
        ])
        ->assertRedirect(route('posts.index'));

    $post->refresh();

    expect($post->likes_count)->toBe(0)
        ->and($post->dislikes_count)->toBe(1);
});

it('validates reaction type', function () {
    $post = Post::factory()->create([
        'slug' => 'invalid-reaction-post',
    ]);

    $this->from(route('posts.index'))
        ->post(route('posts.reactions.store', $post->slug), [
            'reaction' => 'heart',
        ])
        ->assertRedirect(route('posts.index'))
        ->assertSessionHasErrors('reaction');
});

it('does not increment twice for same reaction in one session', function () {
    $post = Post::factory()->create([
        'slug' => 'same-session-like-post',
        'likes_count' => 0,
        'dislikes_count' => 0,
    ]);

    $this->from(route('posts.index'))
        ->post(route('posts.reactions.store', $post->slug), [
            'reaction' => 'like',
        ]);

    $this->from(route('posts.index'))
        ->post(route('posts.reactions.store', $post->slug), [
            'reaction' => 'like',
        ]);

    $post->refresh();

    expect($post->likes_count)->toBe(1)
        ->and($post->dislikes_count)->toBe(0);
});

it('switches reaction in one session from like to dislike', function () {
    $post = Post::factory()->create([
        'slug' => 'switch-session-reaction-post',
        'likes_count' => 0,
        'dislikes_count' => 0,
    ]);

    $this->from(route('posts.index'))
        ->post(route('posts.reactions.store', $post->slug), [
            'reaction' => 'like',
        ]);

    $this->from(route('posts.index'))
        ->post(route('posts.reactions.store', $post->slug), [
            'reaction' => 'dislike',
        ]);

    $post->refresh();

    expect($post->likes_count)->toBe(0)
        ->and($post->dislikes_count)->toBe(1);
});
