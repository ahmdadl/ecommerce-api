<?php

namespace Modules\Orders\Actions;

use Modules\Carts\Models\Cart;
use Modules\Core\Exceptions\ApiException;
use Modules\Orders\Enums\OrderPaymentStatus;
use Modules\Orders\Enums\OrderStatus;
use Modules\Orders\Models\Order;
use Modules\Orders\Models\PaymentAttempt;

class CreateOrderFromCartAction
{
    public function handle(
        Cart $cart,
        string $paymentMethod,
        ?string $receipt = null,
        OrderStatus $status = OrderStatus::PENDING,
        OrderPaymentStatus $orderPaymentStatus = OrderPaymentStatus::PENDING
    ): ?Order {
        // validate cart
        if ($cart->items()->count() === 0) {
            throw new ApiException(__("orders::t.cart_is_empty"));
        }

        // check if order created before on cart then create payment attempt only
        if (!empty($cart->order_id)) {
            $this->createOrderPaymentAttempt(
                $cart->order_id,
                $paymentMethod,
                $orderPaymentStatus,
                $receipt
            );

            return Order::firstWhere("id", $cart->order_id);
        }

        // create order coupon if found
        $orderCoupon = null;
        if ($cart->coupon) {
            $orderCoupon = CreateOrderCouponAction::new()->handle(
                $cart->coupon,
                $cart->totals->total
            );
        }

        // create order address
        $orderShippingAddress = CreateOrderAddressAction::new()->handle(
            $cart->shippingAddress
        );

        // create order
        /** @var Order $order */
        $order = Order::create([
            "user_id" => user()?->id,
            "shipping_address_id" => $orderShippingAddress->id,
            "coupon_id" => $orderCoupon?->id,
            "totals" => $cart->totals,
            "payment_method" => $paymentMethod,
            "status" => $status,
            "payment_status" => $orderPaymentStatus,
        ]);

        // create order items
        foreach ($cart->items()->with("product")->get() as $item) {
            $order->items()->create([
                "product_id" => $item->product_id,
                "title" => $item->product?->getTranslations("title"),
                "sku" => $item->product?->sku,
                "quantity" => $item->quantity,
                "totals" => $item->totals,
            ]);
        }

        // create order payment attempt
        $this->createOrderPaymentAttempt(
            // @phpstan-ignore-next-line
            $order->id,
            $paymentMethod,
            $orderPaymentStatus,
            $receipt
        );

        $cart->order_id = $order->id;
        $cart->save();

        return $order;
    }

    /**
     * create order payment attempt
     */
    public function createOrderPaymentAttempt(
        string $orderId,
        string $paymentMethod,
        OrderPaymentStatus $orderPaymentStatus,
        ?string $receipt = null
    ): void {
        PaymentAttempt::create([
            "order_id" => $orderId,
            "payment_method" => $paymentMethod,
            "status" => $orderPaymentStatus,
            "receipt" => $receipt,
        ]);
    }
}
