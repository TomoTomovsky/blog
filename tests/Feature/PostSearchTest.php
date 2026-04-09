<?php

use App\Models\Post;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('filters posts by title when q is provided', function () {
    Post::factory()->create([
        'title' => 'Laravel Search Feature',
        'slug' => 'laravel-search-feature',
    ]);

    Post::factory()->create([
        'title' => 'React Basics',
        'slug' => 'react-basics',
    ]);

    $this->get(route('posts.index', ['q' => 'Laravel']))
        ->assertSuccessful()
        ->assertSeeText('Laravel Search Feature')
        ->assertDontSeeText('React Basics');
});

it('shows all posts when no search query is provided', function () {
    Post::factory()->create([
        'title' => 'First Post',
        'slug' => 'first-post',
    ]);

    Post::factory()->create([
        'title' => 'Second Post',
        'slug' => 'second-post',
    ]);

    $this->get(route('posts.index'))
        ->assertSuccessful()
        ->assertSeeText('First Post')
        ->assertSeeText('Second Post');
});
