<?php

namespace Modules\Orders\Http\Requests;

use Illuminate\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Modules\Payments\Models\PaymentMethod;

class CreateOrderRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            "payment_method" => ["required", "string", "max:50"],
            "receipt" => [
                "required_if:payment_method," . PaymentMethod::INSTAPAY,
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
                $paymentMethod = $this->input("payment_method");

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
            },
        ];
    }
}
