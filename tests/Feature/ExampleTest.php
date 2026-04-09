<?php

test('the application returns a successful response', function () {
    $response = $this->get(route('posts.create'));

    $response
        ->assertSuccessful()
        ->assertSee('id="duck-button"', false)
        ->assertSee('id="theme-toggle"', false)
        ->assertSee('click me');
});
