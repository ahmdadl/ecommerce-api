<?php

namespace Modules\Users\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class RegisterUserRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'firstName' => 'required|string|max:150',
            'lastName' => 'required|string|max:150',
            'email' => 'required|string|email|max:150|unique:users',
            'phoneNumber' => 'required|string|max:12',
            'password' => 'required|string|min:8|max:150|confirmed',
        ];
    }

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth('guest')->check();
    }
}
