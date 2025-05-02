<?php

namespace Modules\Orders\Http\Requests;

use Illuminate\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Modules\Addresses\Models\Address;
use Modules\Core\Exceptions\ApiException;
use Modules\Payments\Models\PaymentMethod;

class CreateOrderRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        $paymentMethodsWithReceipt = PaymentMethod::where(
            "require_receipt",
            true
        )
            ->get()
            ->pluck("code");

        return [
            "payment_method" => ["required", "string", "max:50"],
            "receipt" => [
                "required_if:payment_method," .
                $paymentMethodsWithReceipt->implode(","),
                "nullable",
                "string",
                "max:255",
                "exists:uploads,id",
            ],
        ];
    }

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * {@inheritDoc}
     */
    public function after(): array
    {
        return [
            function (Validator $validator) {
                $paymentMethod = $this->string("payment_method")->value();

                if (empty($paymentMethod)) {
                    return;
                }

                $paymentMethodRecord = PaymentMethod::active()
                    ->code($paymentMethod)
                    ->first();

                if (!$paymentMethodRecord) {
                    $validator
                        ->errors()
                        ->add(
                            "payment_method",
                            __("order::t.payment_method_not_found")
                        );
                }

                $this->merge(compact("paymentMethodRecord"));

                // validate cart
                $cart = cartService()->cart;
                if ($cart->items()->count() === 0) {
                    throw new ApiException(__("orders::t.cart_is_empty"));
                }

                if ($cart->shipping_address_id) {
                    if (
                        !user("customer")
                            ?->addresses()
                            ->where("id", $cart->shipping_address_id)
                            ->exists()
                    ) {
                        throw new ApiException(
                            __("orders::t.shipping_address_not_found")
                        );
                    }
                } else {
                    throw new ApiException(
                        __("orders::t.shipping_address_is_required")
                    );
                }
            },
        ];
    }
}
