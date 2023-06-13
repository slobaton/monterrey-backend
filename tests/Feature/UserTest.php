<?php
namespace Tests\Feature;

use App\Models\User;
use Symfony\Component\HttpFoundation\Response;
use function Pest\Laravel\getJson;
use function Pest\Laravel\deleteJson;
use function Pest\Laravel\postJson;
use function Pest\Laravel\putJson;

it('should return every user (index)', function () {
    User::factory()->count(3)->create();

    $users = getJson(route('users.index'))
        ->assertStatus(Response::HTTP_OK)
        ->json('data');

    expect($users)->toHaveCount(3);
});

it('should create a user (store)', function () {
    $user = [
        'name'             => 'Sergio',
        'paternal_surname' => 'Lobaton',
        'maternal_surname' => 'Arcani',
        'email'            => 'lobaton.0722@gmail.com',
        'username'         => 'slobaton',
        'password'         => 'sergio123!',
        'password_confirmation' => 'sergio123!'
    ];
    $response = postJson(route('users.store'), $user)
        ->assertStatus(Response::HTTP_CREATED);

    expect($response->getData())
        ->message->toBe('User has been created');
});

it('should update an existing user (update)', function () {

    $user = User::factory()->create();

    $newData = [
        'name'             => 'Sergio',
        'paternal_surname' => 'Lobaton',
        'maternal_surname' => 'Arcani',
        'username'         => $user->username,
        'email'            => $user->email
    ];

    $updatedUser = putJson(
        route('users.update', compact('user')),
        $newData,
    )
        ->assertStatus(Response::HTTP_OK)
        ->json('data');

    expect($updatedUser)
        ->name->toBe($newData['name'])
        ->paternal_surname->toBe($newData['paternal_surname'])
        ->maternal_surname->toBe($newData['maternal_surname'])
        ->username->toBe($user->username)
        ->email->toBe($user->email);
});

it('should return a user (show)', function () {
    $user = User::factory([
        'name'             => 'Pamela',
        'paternal_surname' => 'Rocha',
        'maternal_surname' => 'Arcani',
        'email'            => 'pamela.0722@gmail.com',
        'username'         => 'procha'
    ])->create();

    $response = getJson(route('users.show', ['user' => $user->id]))->json('data');
    expect($response)->toMatchArray([
        'name'             => 'Pamela',
        'paternal_surname' => 'Rocha',
        'maternal_surname' => 'Arcani',
        'email'            => 'pamela.0722@gmail.com',
        'username'         => 'procha'
    ]);
});

it('should delete a user (destroy)', function () {
    $user = User::factory()->create();

    deleteJson(route('users.destroy', ['user' => $user->id]))
        ->assertStatus(Response::HTTP_OK);

    $this->assertDatabaseCount('users', 0);
});
