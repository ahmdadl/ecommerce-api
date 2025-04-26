<?php

namespace Modules\Orders\Actions;

use Modules\Core\Exceptions\ApiException;
use Modules\Core\Traits\HasActionHelpers;
use Modules\Orders\Enums\OrderPaymentStatus;
use Modules\Orders\Enums\OrderStatus;
use Modules\Orders\Enums\OrderStatusLogType;
use Modules\Orders\Models\Order;

class ChangeOrderPaymentStatusAction
{
    use HasActionHelpers;

    public function handle(
        Order $order,
        OrderPaymentStatus $paymentStatus,
        ?string $notes = null
    ) {
        $currentStatus = $order->status;

        if ($paymentStatus === $currentStatus) {
            throw new ApiException(
                "Order payment is already in {$paymentStatus->value} status"
            );
        }

        $order->payment_status = $paymentStatus;
        $order->save();

        $order->statusLogs()->create([
            "status" => $paymentStatus,
            "type" => OrderStatusLogType::PAYMENT,
            "user_id" => auth("web")->id(),
            "notes" => $notes,
        ]);
    }
}
