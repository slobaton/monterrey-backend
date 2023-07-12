<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreWashOrderDetailRequest extends FormRequest
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
            'wash_order_id'    => 'required|string|exists:App\Models\Client,id',
            'cloth_type_id' => 'required|integer|exists:App\Models\WashType,id',
            'cloth_size_id'         => 'required|date',
            'is_special_wash'   => 'required|integer',
            'wash_price'      => 'nullable|sometimes|decimal:2',
            'effect_price' => 'nullable|sometimes|integer',
            'num_buttonholes' => 'nullable|sometimes|date',
            'additional_price' => 'nullable|sometimes|string',
            'additional_price_desc' => '',
            'unit_price' => '',
            'quantity' => '',
            'sub_total_price' => '',
            'observations' => ''
        ];
    }
}
