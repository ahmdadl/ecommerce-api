<?php

use Illuminate\Support\Facades\Notification;
use Modules\Core\Exceptions\ApiException;
use Modules\Orders\Actions\ChangeOrderStatusAction;
use Modules\Orders\Enums\OrderStatus;
use Modules\Orders\Models\Order;
use Modules\Orders\Models\OrderStatusLog;
use Modules\Users\Notifications\OrderStatusUpdatedNotification;

use function Pest\Laravel\assertDatabaseHas;

it(
    "cannot change order status if order is already in that status",
    function () {
        $order = Order::factory()->create([
            "status" => OrderStatus::PENDING,
        ]);

        expect(
            fn() => ChangeOrderStatusAction::new()->handle(
                $order,
                OrderStatus::PENDING
            )
        )->toThrow(ApiException::class);
    }
);

it("can change order status", function () {
    Notification::fake();

    asCustomer();

    $order = Order::factory()->create([
        "status" => OrderStatus::PENDING,
    ]);

    Notification::assertNothingSent();

    ChangeOrderStatusAction::new()->handle($order, OrderStatus::DELIVERED);

    expect($order->status)->toBe(OrderStatus::DELIVERED);

    Notification::assertSentTo(
        $order->user,
        OrderStatusUpdatedNotification::class
    );

    assertDatabaseHas((new OrderStatusLog())->getTable(), [
        "status" => OrderStatus::DELIVERED->value,
        "order_id" => $order->id,
    ]);
});
