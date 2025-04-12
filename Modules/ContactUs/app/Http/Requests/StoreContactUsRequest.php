<?php

namespace Modules\ContactUs\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Modules\Core\Rules\PhoneNumber;

class StoreContactUsRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            "name" => ["required", "string", "max:100"],
            "email" => ["required", "email", "max:255"],
            "phone" => ["nullable", "string", "max:15", new PhoneNumber()],
            "subject" => ["required", "string", "max:150"],
            "message" => ["required", "string", "max:1000"],
            "order_id" => ["nullable", "string", "max:50"],
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
