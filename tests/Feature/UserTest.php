<?php
namespace Tests\Feature;

use Symfony\Component\HttpFoundation\Response;
use function Pest\Laravel\postJson;

it('should create a user', function () {
    $user = [
        'name' => 'Pamela',
        'paternal_surname' => 'Rocha',
        'maternal_surname' => 'Arcani',
        'email' => 'pamela.0722@gmail.com',
        'username' => 'procha',
        'password' => 'sergio123!',
        'password_confirmation' => 'sergio123!'
    ];
    $response = postJson(route('users.store'), $user)
        ->assertStatus(Response::HTTP_CREATED);

    expect($response->getData())
        ->message->toBe('User has been created');
});

