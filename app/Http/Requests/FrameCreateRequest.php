<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class FrameCreateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:60', Rule::unique('frames', 'name')],
            'price' => ['required', 'numeric'],
            'static_src' => ['required', 'string', 'max:255'],
            'animated_src' => ['required', 'string', 'max:255'],
            'valid_duration' => ['nullable', 'integer', 'min:0'],
            'status' => ['nullable', 'integer']
        ];
    }
}
