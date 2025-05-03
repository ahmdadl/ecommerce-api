<?php

namespace Modules\Orders\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Modules\Carts\Actions\CreateShippingAddressAction;
use Modules\Core\Services\Application;
use Modules\Orders\Actions\CreateGuestOrderAction;
use Modules\Orders\Actions\CreateOrderFromCartAction;
use Modules\Orders\Actions\TurnGuestToCustomerAction;
use Modules\Orders\Http\Requests\CreateGuestOrderRequest;
use Modules\Orders\Transformers\OrderResource;
use Modules\Payments\Models\PaymentMethod;
use Modules\Users\Transformers\CustomerResource;

class CreateGuestOrderController extends Controller
{
    public function __invoke(
        CreateGuestOrderRequest $request,
        CreateGuestOrderAction $action
    ) {
        cartService()->refresh();

        $result = DB::transaction(function () use ($request, $action) {
            return $action->handle($request->validated());
        });

        if (!$result[0] || !$result[1]) {
            return api()->error();
        }

        [$user, $order] = $result;

        /** @var PaymentMethod $paymentMethod */
        $paymentMethod = $request->paymentMethodRecord;

        if (!$paymentMethod->is_online) {
            cartService()->destroy();

            return api()->success([
                "record" => new OrderResource($order),
                "user" => new CustomerResource($user),
            ]);
        }

        if ($paymentMethod->is_online) {
            return api()->success([
                "payment_url" => route(
                    "payments.index",
                    $order->paymentAttempts()->latest()->first()
                ),
                "user" => new CustomerResource($user),
            ]);
        }

        return api()->error();
    }
}
