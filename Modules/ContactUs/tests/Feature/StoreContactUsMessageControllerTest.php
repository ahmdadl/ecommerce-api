<?php

use Modules\ContactUs\Models\ContactUsMessage;

use function Pest\Laravel\postJson;

it("can_not_store_message_with_invalid_data", function () {
    $response = postJson(
        route("api.contact-us.store"),
        [],
        [
            "X-PUBLIC-Token" => env("AUTH_PUBLIC_TOKEN"),
        ]
    )->assertStatus(422);
});

it("can_store_message_with_valid_data", function () {
    postJson(
        route("api.contact-us.store"),
        ContactUsMessage::factory()->raw(),
        [
            "X-PUBLIC-Token" => env("AUTH_PUBLIC_TOKEN"),
        ]
    )->assertNoContent();

    $this->assertCount(1, ContactUsMessage::all());
});
