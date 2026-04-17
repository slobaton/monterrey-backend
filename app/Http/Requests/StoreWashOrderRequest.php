<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreWashOrderRequest extends FormRequest
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
            'client_id'    => 'required|string|exists:App\Models\Client,id',
            'wash_type_id' => 'exclude_if:is_rewash,true|required|integer|exists:App\Models\WashType,id',
            'date'         => 'required|date',
            'deliver_quantity' => 'nullable|sometimes|integer',
            'deliver_date' => 'nullable|sometimes|date',
            'observations' => 'nullable|sometimes|string',
            'is_special_price' => 'required|boolean',
            'is_rewash' => 'required|boolean',
            'rewash_price' => 'exclude_unless:is_rewash,true|required|numeric|min:0|max:99999999,99'
        ];
    }
}
