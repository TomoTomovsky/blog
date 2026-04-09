<?php

it('shows the post create captcha gate', function () {
    $this->get(route('posts.create'))
        ->assertSuccessful()
        ->assertSee('id="create-post-form"', false)
        ->assertSee('id="robot-check-button"', false)
        ->assertSee('id="captcha-modal"', false)
        ->assertSee('id="captcha-yes-button"', false)
        ->assertSee('id="captcha-no-button"', false)
        ->assertSee('Ty no szkoda');
});

it('keeps create button as non-submitting until captcha completes', function () {
    $this->get(route('posts.create'))
        ->assertSuccessful()
        ->assertSee('type="button"', false)
        ->assertDontSee('window.confirm')
        ->assertSee('form.submit()', false);
});
