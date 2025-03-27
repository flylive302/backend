<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class CoinRequestCreateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'amount' => 'required|numeric|min:0.01',
            'message' => 'nullable|string|max:255',
            'proof_1' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'proof_2' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'proof_3' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'type' => 'required|integer|in:1,2',
            'credit_days' => 'nullable|integer|min:1|max:365',
        ];
    }
}
