<?php

use Modules\Addresses\Models\Address;
use Modules\Carts\Models\Cart;
use Modules\Carts\Models\CartItem;
use Modules\Guests\Models\Guest;
use Modules\Orders\Actions\CreateGuestOrderAction;
use Modules\Orders\Actions\TurnGuestToCustomerAction;
use Modules\Payments\Models\PaymentMethod;
use Modules\Users\Notifications\ChangeGuestPasswordNotification;
use Modules\Users\Notifications\NewCustomerNotification;

use function Pest\Laravel\assertDatabaseHas;

it("creates_new_customer_from_address", function () {
    $address = Address::factory()->make();

    Notification::fake();

    Notification::assertNothingSent();

    asGuest();

    $guestToCustomerAction = app(TurnGuestToCustomerAction::class);

    [$user] = $guestToCustomerAction->handle($address->toArray());

    Notification::assertSentTo($user, NewCustomerNotification::class);
    Notification::assertSentTo($user, ChangeGuestPasswordNotification::class);
});

it("creates_order_for_guest_from_address", function () {
    asGuest($guest = Guest::factory()->create());

    $address = Address::factory()->make([
        "user_id" => null,
    ]);

    $cart = Cart::factory()->for($guest, "cartable")->create();
    CartItem::factory()->for($cart)->create();

    $createOrderAction = app(CreateGuestOrderAction::class);

    $createOrderAction->handle([
        "address" => $address->toArray(),
        "payment_method" => PaymentMethod::CASH_ON_DELIVERY,
        "receipt" => null,
    ]);

    assertDatabaseHas("orders", [
        "payment_method" => PaymentMethod::CASH_ON_DELIVERY,
    ]);
    assertDatabaseHas("users", [
        "email" => $address->email,
        "phone" => $address->phone,
    ]);
    assertDatabaseHas("addresses", [
        "email" => $address->email,
        "phone" => $address->phone,
    ]);
});
