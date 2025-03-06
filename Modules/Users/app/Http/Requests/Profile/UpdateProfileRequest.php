<?php

namespace Modules\Users\Http\Requests\Profile;

use Illuminate\Foundation\Http\FormRequest;
use Modules\Users\Enums\UserGender;

class UpdateProfileRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            "name" => "required|string|max:150",
            "email" =>
                "required|email|max:150|unique:users,email," .
                auth("customer")->id(),
            "phoneNumber" =>
                "required|string|max:20|unique:users,phoneNumber," .
                auth("customer")->id(),
            "gender" => "required|enum:" . UserGender::class,
        ];
    }

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth("customer")->check();
    }
}
