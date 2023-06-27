<?php
namespace Tests\Feature;

use App\Enums\Roles;
use App\Models\Role;
use App\Models\User;
use App\Models\Effect;
use Laravel\Sanctum\Sanctum;
use function Pest\Laravel\getJson;
use function Pest\Laravel\putJson;
use function Pest\Laravel\postJson;
use function Pest\Laravel\deleteJson;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Foundation\Testing\RefreshDatabase;

beforeEach(function () {
    $user = User::factory()->create();
    $user->roles()->attach(Role::create(['name' => Roles::ADMIN->value]));
    Sanctum::actingAs($user);
});

it('should return every effect (index)', function () {
    Effect::factory()->count(3)->create();

    $effects = getJson(route('effects.index'), )
        ->assertStatus(Response::HTTP_OK)
        ->json('data');

    expect($effects)->toHaveCount(3);
});

it('should create a effect (store)', function () {
    $effectData = [
        'name'        => 'Amarrado',
        'description' => 'Se realiza la lija de la prenda con instrumentos personalizados',
        'price'       => 150.3,
    ];
    $response = postJson(route('effects.store'), $effectData)
        ->assertStatus(Response::HTTP_CREATED);

    expect($response->getData())
        ->message->toBe('Effect has been created');
});

it('should update an existing effect (update)', function () {
    $effect = Effect::factory()->create();
    $newData = [
        'name'        => 'Sergio',
        'description' => 'Se realiza la lija de la prenda con instrumentos personalizados',
        'price'       => 150.3
    ];

    $updatedEffect = putJson(
        route('effects.update', compact('effect')),
        $newData,
    )
        ->assertStatus(Response::HTTP_OK)
        ->json('data');

    expect($updatedEffect)
        ->name->toBe($newData['name'])
        ->description->toBe($newData['description'])
        ->price->toBe($newData['price']);
});

it('should return a filter (show)', function () {
    $effect = Effect::factory([
        'name'        => 'Sergio',
        'description' => 'Se realiza la lija de la prenda con instrumentos personalizados',
        'price'       => 150.3
    ])->create();

    $response = getJson(route('effects.show', ['effect' => $effect->id]))->json('data');

    expect($response)->toMatchArray([
        'name'        => 'Sergio',
        'description' => 'Se realiza la lija de la prenda con instrumentos personalizados',
        'price'       => 150.3
    ]);
});

it('should delete a effect (destroy)', function () {
    $effect = Effect::factory()->create();
    deleteJson(route('effects.destroy', ['effect' => $effect->id]))
        ->assertStatus(Response::HTTP_OK);

    $this->assertDatabaseMissing('effects', $effect->toArray());
});
