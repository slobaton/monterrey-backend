<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreClothSizeRequest extends FormRequest
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
            'name' => 'required|string|max:255|unique:App\Models\ClothSize,name',
            'description' => 'nullable|sometimes|string',
            'wash_price' => 'required|numeric|max:99999999,99',
            'wash_special_price' => 'nullable|sometimes|numeric|max:99999999,99'
        ];
    }
}
