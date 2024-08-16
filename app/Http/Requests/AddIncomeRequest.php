<?php

namespace App\Http\Requests;

use App\Enums\IncomeType;
use App\Rules\ValidIncomeReceiptNumberRule;
use Illuminate\Foundation\Http\FormRequest;

class AddIncomeRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'receipt_number' => ['required', 'numeric', 'min:1', new ValidIncomeReceiptNumberRule(IncomeType::OTHER)],
            'amount' => ['required', 'numeric', 'min:1'],
            'date' => 'sometimes|nullable|date',
            'concept' => 'required|string|max:100',
            'client_name' => 'sometimes|nullable|string'
        ];
    }
}
