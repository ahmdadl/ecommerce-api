<?php

namespace Modules\Addresses\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Modules\Core\Rules\PhoneNumber;

class CreateAddressRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            "government_id" => ["required", "ulid", "exists:governments,id"],
            "city_id" => ["required", "ulid", "exists:cities,id"],
            "first_name" => ["required", "string", "max:50"],
            "last_name" => ["required", "string", "max:50"],
            "title" => ["nullable", "string", "max:100"],
            "address" => ["required", "string", "max:250"],
            "phone" => [
                "required",
                "string",
                "max:12",
                new PhoneNumber(),
                "unique:addresses,phone,NULL,user_id,deleted_at,NULL",
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
}
