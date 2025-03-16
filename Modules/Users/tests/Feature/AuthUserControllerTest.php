<?php

use Modules\Users\Models\Auth\PasswordResetToken;
use Modules\Users\Models\Customer;
use Modules\Users\Models\User;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\assertDatabaseMissing;
use function Pest\Laravel\postJson;
use function Pest\Laravel\travel;

it("is_no_access_for_non_guests", function () {
    postJson(route("api.auth.login"))->assertUnauthorized();
});

test("guest_cannot_login_with_invalid_credentials", function () {
    asGuest();

    postJson(route("api.auth.login"), [
        "email" => "test",
        "password" => "test",
    ])
        ->assertJsonValidationErrorFor("email")
        ->assertJsonValidationErrorFor("password");
});

test("guest_can_login_with_valid_credentials", function () {
    asGuest();

    $user = User::factory()->customer()->create();

    $response = postJson(route("api.auth.login"), [
        "email" => $user->email,
        "password" => ($password = "123123123"),
        "password_confirmation" => $password,
    ])->assertOk();

    $response
        ->assertSee("name")
        ->assertSee("email")
        ->assertSee("access_token")
        ->assertSee("totals");
});

test("user_cannot_login", function () {
    $user = User::factory()->customer()->create();

    actingAs($user, "customer");

    postJson(route("api.auth.login"), [
        "email" => $user->email,
        "password" => "123123123",
        "password_confirmation" => "123123123",
    ])->assertUnauthorized();
});

test("only_guest_can_register", function () {
    postJson(route("api.auth.register"))->assertUnauthorized();

    $user = User::factory()->customer()->create();

    actingAs($user, "customer");

    postJson(route("api.auth.register"))->assertUnauthorized();
});

test("guest_cannot_register_with_invalid_data", function () {
    asGuest();

    postJson(route("api.auth.register"))
        ->assertJsonValidationErrorFor("firstName")
        ->assertJsonValidationErrorFor("lastName")
        ->assertJsonValidationErrorFor("email")
        ->assertJsonValidationErrorFor("phoneNumber")
        ->assertJsonValidationErrorFor("password");
});

test("guest_can_register_with_valid_data", function () {
    asGuest();

    postJson(route("api.auth.register"), [
        "firstName" => "John",
        "lastName" => "Doe",
        "email" => fake()->unique()->safeEmail,
        "phoneNumber" => "123123123",
        "password" => ($password = "123123123"),
        "password_confirmation" => $password,
    ])
        ->assertOk()
        ->assertSee("totals")
        ->assertSee("access_token");
});

test("only_guest_can_reset_password", function () {
    postJson(route("api.auth.forget-password"))->assertUnauthorized();
    postJson(route("api.auth.reset-password"))->assertUnauthorized();

    asGuest();

    postJson(route("api.auth.forget-password"))->assertJsonValidationErrorFor(
        "email"
    );
    postJson(route("api.auth.reset-password"))
        ->assertJsonValidationErrorFor("email")
        ->assertJsonValidationErrorFor("token");
});

test("user_cannot_reset_password_with_invalid_data", function () {
    asGuest();

    postJson(route("api.auth.forget-password"), ["email" => fake()->email])
        ->assertStatus(400)
        ->assertSee(__("users::t.email_not_found"));
    postJson(
        route("api.auth.reset-password", [
            "email" => fake()->email,
            "password" => ($password = str()->random(8)),
            "password_confirmation" => $password,
            "token" => str()->random(6),
        ])
    )
        ->assertStatus(400)
        ->assertSee(__("users::t.invalid_credentials"));

    $user = User::factory()->customer()->create();
    postJson(route("api.auth.forget-password"), [
        "email" => $user->email,
    ])->assertNoContent();

    // test invalid token
    postJson(
        route("api.auth.reset-password", [
            "email" => $user->email,
            "password" => ($password = str()->random(8)),
            "password_confirmation" => $password,
            "token" => str()->random(6),
        ])
    )
        ->assertStatus(400)
        ->assertSee(__("users::t.invalid_token"));

    // test token expired
    $passwordReset = PasswordResetToken::where("email", $user->email)
        ->latest()
        ->first();

    travel(6)->minutes();

    postJson(
        route("api.auth.reset-password", [
            "email" => $user->email,
            "password" => ($password = str()->random(8)),
            "password_confirmation" => $password,
            "token" => $passwordReset->token,
        ])
    )
        ->assertStatus(400)
        ->assertSee(__("users::t.token_expired"));
});

test("user_can_reset_password", function () {
    asGuest();

    $user = User::factory()->customer()->create();

    postJson(route("api.auth.forget-password"), [
        "email" => $user->email,
    ])->assertNoContent();

    $passwordReset = PasswordResetToken::firstWhere("email", $user->email);

    postJson(route("api.auth.reset-password"), [
        "email" => $user->email,
        "token" => $passwordReset->token,
        "password" => ($password = str()->random(8)),
        "password_confirmation" => $password,
    ])->assertNoContent();

    expect(
        Customer::attempt(["email" => $user->email, "password" => $password])
    )->toBeTrue();

    assertDatabaseMissing("password_reset_tokens", ["email" => $user->email]);
});
