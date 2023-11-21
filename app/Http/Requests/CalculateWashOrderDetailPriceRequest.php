<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CalculateWashOrderDetailPriceRequest extends FormRequest
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
            'is_focalizado_active' => 'nullable|sometimes|boolean',
            'is_nevado_active'     => 'nullable|sometimes|boolean',
            'num_buttonholes'      => 'nullable|sometimes|integer',
            'buttonholes_price'    => 'nullable|sometimes|decimal:0,2',
            'quantity'             => 'nullable|sometimes|integer',
            'effects'              => 'nullable|sometimes|array'
        ];
    }
}
