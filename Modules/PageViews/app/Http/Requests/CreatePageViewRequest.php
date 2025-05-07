<?php

namespace Modules\PageViews\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Modules\PageViews\Enums\ViewableType;

class CreatePageViewRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            "type" => ["required", "string", Rule::enum(ViewableType::class)],
            "slug" => ["required", "string"],
            "user_agent" => ["required", "string"],
            "page" => ["nullable", "string"],
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
