<?php

namespace Modules\Orders\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Modules\Addresses\Http\Requests\CreateAddressRequest;
use Modules\Core\Rules\PhoneNumber;

class CreateGuestOrderRequest extends CreateOrderRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        $parentRules = parent::rules();

        return [
            ...$parentRules,

            "address" => "required",
            "address.government_id" => [
                "required",
                "ulid",
                "exists:governments,id",
            ],
            "address.city_id" => ["required", "ulid", "exists:cities,id"],
            "address.first_name" => ["required", "string", "max:50"],
            "address.last_name" => ["required", "string", "max:50"],
            "address.title" => ["nullable", "string", "max:100"],
            "address.email" => "required|email|max:150|unique:users,email",
            "address.phone" => [
                "required",
                "string",
                "max:12",
                new PhoneNumber(),
                "unique:users,phone",
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
     * Prepare the data for validation.
     *
     * @return void
     */
    protected function prepareForValidation()
    {
        /** @var \Illuminate\Http\Request $this */
        $this->lowercaseEmail();
    }
}
