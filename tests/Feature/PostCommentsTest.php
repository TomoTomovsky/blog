<?php

use App\Models\Comment;
use App\Models\Post;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('shows comments on a post page', function () {
    $post = Post::factory()->create([
        'slug' => 'example-post',
    ]);

    Comment::factory()->for($post)->create([
        'author' => 'Anna Nowak',
        'content' => 'Bardzo pomocny wpis.',
    ]);

    $this->get(route('posts.show', $post->slug))
        ->assertSuccessful()
        ->assertSeeText('Komentarze (1)')
        ->assertSeeText('Anna Nowak')
        ->assertSeeText('Bardzo pomocny wpis.');
});

it('stores a comment for a post', function () {
    $post = Post::factory()->create([
        'slug' => 'new-comment-post',
    ]);

    $response = $this->post(route('posts.comments.store', $post->slug), [
        'author' => 'Jan Kowalski',
        'email' => 'jan@example.com',
        'content' => 'Super artykul i bardzo przydatne wskazowki.',
    ]);

    $response
        ->assertRedirect(route('posts.show', $post->slug).'#comments')
        ->assertSessionHas('success', 'Komentarz został dodany.');

    $this->assertDatabaseHas('comments', [
        'post_id' => $post->id,
        'author' => 'Jan Kowalski',
        'email' => 'jan@example.com',
        'content' => 'Super artykul i bardzo przydatne wskazowki.',
    ]);
});

it('validates comment data', function () {
    $post = Post::factory()->create([
        'slug' => 'validation-post',
    ]);

    $this->from(route('posts.show', $post->slug))
        ->post(route('posts.comments.store', $post->slug), [
            'author' => '',
            'email' => 'bad-email',
            'content' => '',
        ])
        ->assertRedirect(route('posts.show', $post->slug))
        ->assertSessionHasErrors(['author', 'email', 'content']);
});
