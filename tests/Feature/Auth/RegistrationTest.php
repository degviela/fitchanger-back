<?php

test('new users can register', function () {
    $response = $this->post('/register', [
        'firstName' => 'Test User',
        'lastName' => 'Test User',
        'username' => 'testtest',
        'email' => 'test@example.com',
        'password' => 'password',
        'password_confirmation' => 'password',
    ]);

    $this->assertAuthenticated();
    $response->assertNoContent();
});
