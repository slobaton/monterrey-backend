<?php

namespace App\Http\Requests;

use App\Rules\ValidCancelableIncomeReceiptRule;
use Illuminate\Foundation\Http\FormRequest;

class CancelIncomeReceiptRequest extends FormRequest
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
            'receipt_number' => ['required', 'numeric', 'min:1', new ValidCancelableIncomeReceiptRule],
            'canceled_reason' => 'required|string',
            'date' => 'sometimes|nullable|date'
        ];
    }
}
