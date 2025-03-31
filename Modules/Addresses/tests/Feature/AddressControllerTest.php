<?php

use Modules\Addresses\Models\Address;
use Modules\Users\Models\User;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\assertDatabaseMissing;
use function Pest\Laravel\deleteJson;
use function Pest\Laravel\patchJson;
use function Pest\Laravel\postJson;

test("user_cannot_create_address_without_login", function () {
    postJson(route("api.addresses.store"), [])->assertUnauthorized();

    asGuest();

    postJson(route("api.addresses.store"), [])->assertUnauthorized();
});

test("user_can_create_address", function () {
    $user = User::factory()->customer()->create();

    Address::factory()->create();

    actingAs($user);

    postJson(route("api.addresses.store"), [
        ...Address::factory()->make()->toArray(),
        "phone" => ($phone = fakePhone()),
    ])
        ->assertOk()
        ->assertSee($phone);

    assertDatabaseHas("addresses", [
        "user_id" => $user->id,
        "phone" => $phone,
    ]);

    expect($user->addresses()->count())->toBe(1);
});

test("user_can_update_only_owned_address", function () {
    $user = User::factory()->customer()->create();
    $address = Address::factory()->create();

    actingAs($user);

    patchJson(route("api.addresses.update", $address), [])->assertNotFound();
});

test("user_can_update_address", function () {
    $user = User::factory()->customer()->create();
    $address = Address::factory()->for($user)->create();

    $phone = fakePhone();
    expect($address->phone)->not->toBe($phone);

    actingAs($user);

    patchJson(route("api.addresses.update", $address), [
        ...Address::factory()->make()->toArray(),
        "phone" => $phone,
    ])
        ->assertOk()
        ->assertSee($phone);

    assertDatabaseHas("addresses", [
        "user_id" => $user->id,
        "phone" => $phone,
    ]);

    expect($user->addresses()->count())->toBe(1);

    expect($user->addresses()->first()->phone)->toBe($phone);
});

test("user_can_delete_only_owned_address", function () {
    $user = User::factory()->customer()->create();
    $address = Address::factory()->create();

    actingAs($user);

    deleteJson(route("api.addresses.destroy", $address), [])->assertNotFound();
});

test("user_can_delete_address", function () {
    $user = User::factory()->customer()->create();
    $address = Address::factory()->for($user)->create();

    actingAs($user);

    deleteJson(route("api.addresses.destroy", $address), [])->assertNoContent();

    expect($user->addresses()->count())->toBe(0);

    assertDatabaseMissing("addresses", [
        "id" => $address->id,
        "deleted_at" => null,
    ]);
});
