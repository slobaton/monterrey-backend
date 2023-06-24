<?php

namespace Tests\Feature;

use App\Enums\Roles;
use App\Models\User;
use App\Models\Client;
use App\Models\Role;
use Laravel\Sanctum\Sanctum;
use function Pest\Laravel\getJson;
use function Pest\Laravel\putJson;
use function Pest\Laravel\postJson;
use function Pest\Laravel\deleteJson;
use Symfony\Component\HttpFoundation\Response;

beforeEach(function () {
    $user = User::factory()->create();
    $user->roles()->attach(Role::create(['name' => Roles::ADMIN->value]));
    Sanctum::actingAs($user);
});

it('should return every client (index)', function () {
    Client::factory()->count(3)->create();

    $clients = getJson(route('clients.index'))
        ->assertStatus(Response::HTTP_OK)
        ->json('data');

    expect($clients)->toHaveCount(3);
});

it('should create a client (store)', function () {
    $client = [
        'nit'              => '133012233',
        'name'             => 'Abel',
        'paternal_surname' => 'Lopez',
        'maternal_surname' => 'Paniagua',
        'address'            => 'Av. Dorvigni 1725',
        'phone'         => '4412023',
        'cellphone'         => '65788223',
        'observations' => 'Lorem ipsum, test observation'
    ];
    $response = postJson(route('clients.store'), $client)
        ->assertStatus(Response::HTTP_CREATED);

    expect($response->getData())
        ->message->toBe('Client has been created!');
});

it('should update an existing client (update)', function () {

    $client = Client::factory()->create();

    $newData = [
        'id'               => $client->id,
        'nit'              => $client->nit,
        'name'             => 'Marco',
        'paternal_surname' => 'Peredo',
        'maternal_surname' => 'Paniagua',
        'address'            => $client->address,
        'phone'         => $client->phone,
        'cellphone'         => '65788224',
        'observations' => $client->observations,
        'is_active' => false
    ];

    $updatedClient = putJson(
        route('clients.update', compact('client')),
        $newData,
    )
        ->assertStatus(Response::HTTP_OK)
        ->json('data');

    expect($updatedClient)
        ->nit->toBe($newData['nit'])
        ->name->toBe($newData['name'])
        ->paternal_surname->toBe($newData['paternal_surname'])
        ->maternal_surname->toBe($newData['maternal_surname'])
        ->address->toBe($client->address)
        ->phone->toBe($client->phone)
        ->cellphone->toBe($newData['cellphone'])
        ->observations->toBe($client->observations)
        ->is_active->toBe(false);
});

it('should return a client (show)', function () {
    $client = Client::factory([
        'nit'              => '133012233',
        'name'             => 'Abel',
        'paternal_surname' => 'Lopez',
        'maternal_surname' => 'Paniagua',
        'address'            => 'Av. Dorvigni 1725',
        'phone'         => '4412023',
        'cellphone'         => '65788223',
        'observations' => 'Lorem ipsum, test observation'
    ])->create();

    $response = getJson(route('clients.show', ['client' => $client->id]))->json('data');
    expect($response)->toMatchArray([
        'nit'              => '133012233',
        'name'             => 'Abel',
        'paternal_surname' => 'Lopez',
        'maternal_surname' => 'Paniagua',
        'address'            => 'Av. Dorvigni 1725',
        'phone'         => '4412023',
        'cellphone'         => '65788223',
        'observations' => 'Lorem ipsum, test observation'
    ]);
});

it('should delete a client (destroy)', function () {
    $client = Client::factory()->create();

    deleteJson(route('clients.destroy', ['client' => $client->id]))
        ->assertStatus(Response::HTTP_OK);

    $this->assertDatabaseCount('clients', 0);
});
