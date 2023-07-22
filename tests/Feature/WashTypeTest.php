<?php

namespace Tests\Feature;

use App\Enums\Roles;
use App\Models\User;
use App\Models\Role;
use App\Models\WashType;
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

it('should return every wash type (index)', function () {
    WashType::factory()->count(3)->create();

    $washTypes = getJson(route('wash-types.index'))
        ->assertStatus(Response::HTTP_OK)
        ->json('data');

    expect($washTypes)->toHaveCount(3);
});

it('should create a wash type (store)', function () {
    $washType = [
        'name'        => 'WashType Mock',
        'price'       => 199.50,
        'description' => 'Lorem ipsum, test observation'
    ];
    $response = postJson(route('wash-types.store'), $washType)
        ->assertStatus(Response::HTTP_CREATED);

    expect($response->getData())
        ->message->toBe('Wash Type has been created!');
});

it('should update an existing wash type (update)', function () {

    $washType = WashType::factory()->create();

    $newData = [
        'id'               => $washType->id,
        'name'             => 'WashType Mock',
        'price'            => '199.99',
        'description' => $washType->description,
        'is_active' => false
    ];

    $updatedWashType = putJson(
        route('wash-types.update', ['wash_type' => $washType->id]),
        $newData,
    )
        ->assertStatus(Response::HTTP_OK)
        ->json('data');

    expect($updatedWashType)
        ->name->toBe($newData['name'])
        ->price->toBe($newData['price'])
        ->description->toBe($washType->description)
        ->is_active->toBe(false);
});

it('should return a wash type (show)', function () {
    $washType = WashType::factory([
        'name'             => 'WashType Mock',
        'description'   => 199.99,
        'description' => 'Lorem ipsum, test observation'
    ])->create();

    $response = getJson(route('wash-types.show', ['wash_type' => $washType->id]))->json('data');
    expect($response)->toMatchArray([
        'name'             => 'WashType Mock',
        'description'   => '199.99',
        'description' => 'Lorem ipsum, test observation'
    ]);
});

it('should delete a wash type (destroy)', function () {
    $washType = WashType::factory()->create();

    deleteJson(route('wash-types.destroy', ['wash_type' => $washType->id]))
        ->assertStatus(Response::HTTP_OK);

    $this->assertDatabaseCount('wash_types', 0);
});
