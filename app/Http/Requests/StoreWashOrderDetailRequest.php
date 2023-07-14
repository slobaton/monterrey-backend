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
            'wash_order_id'    => 'required|string|exists:App\Models\WashOrder,id',
            'cloth_type_id'    => 'required|integer|exists:App\Models\ClothType,id',
            'cloth_size_id'    => 'required|integer|exists:App\Models\ClothSize,id',
            'is_special_wash'  => 'sometimes|nullable|boolean',
            'wash_price'       => 'nullable|sometimes|decimal:0,2',
            'effect_price'     => 'nullable|sometimes|decimal:0,2',
            'num_buttonholes'  => 'required|integer',
            'additional_price' => 'nullable|sometimes|string',
            'additional_price_desc' => 'nullable|sometimes|decimal:0,2',
            'unit_price'       => 'nullable|sometimes|decimal:0,2',
            'quantity'         => 'nullable|sometimes|decimal:0,2',
            'sub_total_price'  => 'nullable|sometimes|decimal:0,2',
            'observations'     => 'nullable|sometimes|string'
        ];
    }
}
