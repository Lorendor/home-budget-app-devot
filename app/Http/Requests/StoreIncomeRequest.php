<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreIncomeRequest extends FormRequest
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
            'description' => 'required|string|min:3|max:255',
            'amount' => 'required|numeric|min:0.01|max:999999.99',
            'date' => 'sometimes|date|before_or_equal:today'
        ];
    }

    /**
     * Get custom error messages for validation rules.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'description.required' => 'Income description is required',
            'description.min' => 'Description must be at least 3 characters',
            'description.max' => 'Description cannot exceed 255 characters',
            'amount.required' => 'Amount is required',
            'amount.numeric' => 'Amount must be a valid number',
            'amount.min' => 'Amount must be at least $0.01',
            'amount.max' => 'Amount cannot exceed $999,999.99',
            'date.before_or_equal' => 'Date cannot be in the future'
        ];
    }
}