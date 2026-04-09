<?php

test('the application returns a successful response', function () {
    $response = $this->get(route('posts.create'));

    $response
        ->assertSuccessful()
        ->assertSee('id="duck-button"', false)
        ->assertSee('click me');
});
