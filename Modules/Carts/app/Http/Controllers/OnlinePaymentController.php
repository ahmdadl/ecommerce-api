<?php

namespace Modules\Carts\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Container\Attributes\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB as FacadesDB;
use Illuminate\View\View;
use Modules\Carts\Models\Cart;
use Modules\Orders\Enums\OrderPaymentStatus;
use Modules\Orders\Enums\OrderStatus;
use Modules\Orders\Models\PaymentAttempt;
use Modules\Users\Models\Customer;

class OnlinePaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(
        Request $request,
        PaymentAttempt $paymentAttempt
    ): View {
        $paymentAttempt->update([
            "status" => OrderPaymentStatus::PENDING,
        ]);

        return view("carts::payments.index", compact("paymentAttempt"));
    }

    /**
     * success payment
     */
    public function success(
        Request $request,
        PaymentAttempt $paymentAttempt
    ): View {
        $order = $paymentAttempt->order;

        auth("web")->setUser($order->user);

        $paymentAttempt->updateToSuccess();

        cartService()->destroy();

        return view("carts::payments.success", compact("paymentAttempt"));
    }

    public function afterSuccess(
        Request $request,
        PaymentAttempt $paymentAttempt
    ) {
        return redirect()->to(
            config("app.front_url") .
                "/" .
                app()->getLocale() .
                "/profile/orders/" .
                $paymentAttempt->order_id
        );
    }

    /**
     * failed payment
     */
    public function failed(
        Request $request,
        PaymentAttempt $paymentAttempt
    ): View {
        $paymentAttempt->update([
            "status" => OrderPaymentStatus::FAILED,
        ]);

        return view("carts::payments.failed", compact("paymentAttempt"));
    }

    public function afterFailed(
        Request $request,
        PaymentAttempt $paymentAttempt
    ) {
        return redirect()->to(
            config("app.front_url") .
                "/" .
                app()->getLocale() .
                "/checkout?payment_failed=failed payment, please try again"
        );
    }
}
