<?php

use App\Enums\Roles;
use App\Models\Role;
use App\Models\User;
use App\Models\ClothType;
use Laravel\Sanctum\Sanctum;
use Illuminate\Http\Response;

use function Pest\Laravel\getJson;
use function Pest\Laravel\putJson;
use function Pest\Laravel\postJson;
use function Pest\Laravel\deleteJson;

beforeEach(function () {
    $user = User::factory()->create();
    $user->roles()->attach(Role::create(['name' => Roles::ADMIN->value]));
    Sanctum::actingAs($user);
});

it('should return every cloth type (index)', function () {
    ClothType::factory()->count(3)->create();

    $clothTypes = getJson(route('cloth-types.index'))
        ->assertStatus(Response::HTTP_OK)
        ->json('data');

    expect($clothTypes)->toHaveCount(3);
});

it('should create a cloth type (store)', function () {
    $clothType = [
        'name'        => 'ClothType Mock',
        'description' => 'Lorem ipsum, test observation'
    ];
    $response = postJson(route('cloth-types.store'), $clothType)
        ->assertStatus(Response::HTTP_CREATED);

    expect($response->getData())
        ->message->toBe('Cloth Type has been created!');
});

it('should update an existing cloth type (update)', function () {

    $clothType = ClothType::factory()->create();

    $newData = [
        'id'               => $clothType->id,
        'name'             => 'ClothType Mock',
        'description' => $clothType->description,
        'is_active' => false
    ];

    $updatedClothType = putJson(
        route('cloth-types.update', ['cloth_type' => $clothType->id]),
        $newData,
    )
        ->assertStatus(Response::HTTP_OK)
        ->json('data');

    expect($updatedClothType)
        ->name->toBe($newData['name'])
        ->description->toBe($clothType->description)
        ->is_active->toBe(false);
});

it('should return a cloth type (show)', function () {
    $clothType = ClothType::factory([
        'name'             => 'ClothType Mock',
        'description' => 'Lorem ipsum, test observation'
    ])->create();

    $response = getJson(route('cloth-types.show', ['cloth_type' => $clothType->id]))->json('data');
    expect($response)->toMatchArray([
        'name'          => 'ClothType Mock',
        'description'   => 'Lorem ipsum, test observation'
    ]);
});

it('should delete a cloth type (destroy)', function () {
    $clothType = ClothType::factory()->create();

    deleteJson(route('cloth-types.destroy', ['cloth_type' => $clothType->id]))
        ->assertStatus(Response::HTTP_OK);

    $this->assertDatabaseCount('cloth_types', 0);
});
