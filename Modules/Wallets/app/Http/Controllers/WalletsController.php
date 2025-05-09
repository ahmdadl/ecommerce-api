<?php

namespace Modules\Wallets\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Modules\Payments\Models\PaymentMethod;
use Modules\Payments\Transformers\PaymentMethodResource;
use Modules\Wallets\Actions\GetWalletAction;
use Modules\Wallets\Actions\WalletCreditAction;
use Modules\Wallets\Http\Requests\WalletCreditRequest;

class WalletsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): JsonResponse
    {
        $loadedArray = $request->array("with");

        $response = [];

        $response["record"] = GetWalletAction::new()->handle();

        if (in_array("paymentMethods", $loadedArray)) {
            $response["paymentMethods"] = PaymentMethodResource::collection(
                PaymentMethod::active()
                    ->where("code", "<>", PaymentMethod::WALLET)
                    ->get()
            );
        }

        return api()->success($response);
    }

    /**
     * credit wallet
     */
    public function credit(
        WalletCreditRequest $request,
        WalletCreditAction $action
    ): JsonResponse {
        return DB::transaction(function () use ($action, $request) {
            return $action->handle(
                $request->float("amount"),
                $request->paymentMethodRecord,
                $request->string("receipt")->value(),
                $request->string("notes")->value()
            );
        });
    }
}
