<?php

namespace Modules\Wallets\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;
use Modules\Payments\Models\PaymentMethod;

class WalletCreditRequest extends FormRequest
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
            "amount" => "required|numeric|min:10|max:10000",
            "payment_method" => "required|string|max:50",
            "receipt" => [
                "required_if:payment_method," .
                $paymentMethodsWithReceipt->implode(","),
                "nullable",
                "string",
                "max:255",
                "exists:uploads,id",
            ],
            "notes" => "nullable|string|max:255",
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
                } else {
                    $this->merge(compact("paymentMethodRecord"));
                }
            },
        ];
    }
}
