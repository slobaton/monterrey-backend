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
            'wash_order_id'        => 'required|string|exists:App\Models\WashOrder,id',
            'cloth_type_id'        => 'required|integer|exists:App\Models\ClothType,id',
            'cloth_size_id'        => 'required|integer|exists:App\Models\ClothSize,id',
            'is_focalizado_active' => 'required|boolean',
            'is_nevado_active'     => 'required|boolean',
            'num_buttonholes'      => 'required|integer',
            'buttonholes_price'    => 'required|decimal:0,2',
            'quantity'             => 'required|integer',
            'observations'         => 'nullable|sometimes|string',
            'effects'              => 'nullable|sometimes|array'
        ];
    }
}
