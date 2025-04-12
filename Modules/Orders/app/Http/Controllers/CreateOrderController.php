<?php

namespace Modules\Orders\Http\Controllers;

use App\Http\Controllers\Controller;
use GuzzleHttp\Promise\Create;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Modules\Orders\Actions\CreateOrderFromCartAction;
use Modules\Orders\Http\Requests\CreateOrderRequest;
use Modules\Orders\Transformers\OrderResource;
use Modules\Payments\Models\PaymentMethod;

class CreateOrderController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(
        CreateOrderRequest $request,
        CreateOrderFromCartAction $action
    ): JsonResponse {
        cartService()->refresh();

        // should be moved to queue
        $order = $action->handle(
            cartService()->cart,
            $request->string("payment_method")->value(),
            $request->input("receipt")
        );

        /** @var PaymentMethod $paymentMethod */
        $paymentMethod = $request->paymentMethodRecord;

        if (!$paymentMethod->is_online) {
            cartService()->destroy();

            return api()->record(new OrderResource($order));
        }

        if ($paymentMethod->is_online) {
            return api()->success([
                "payment_url" => route(
                    "payments.index",
                    $order->paymentAttempts()->latest()->first()
                ),
            ]);
        }

        return api()->error();
    }
}
