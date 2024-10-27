<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('new users can register', function () {
    $this->withoutExceptionHandling();

    $response = $this->post('/register', [
        'firstName' => 'Test User',
        'lastName' => 'Test User',
        'username' => 'testtest',
        'email' => 'test@example.com',
        'password' => 'password',
        'password_confirmation' => 'password',
    ], [
        'Accept' => 'application/json',
        'X-Requested-With' => 'XMLHttpRequest'
    ]);

    $this->assertAuthenticated();
    $response->assertNoContent();
});
