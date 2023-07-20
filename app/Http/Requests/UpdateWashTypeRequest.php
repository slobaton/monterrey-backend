<?php

namespace App\Http\Requests;

use App\Models\WashType;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateWashTypeRequest extends FormRequest
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
            'name' => [
                'required',
                'string',
                'max:150',
                Rule::unique('wash_types', 'name')->ignore($this->request->get('id'), 'id')
            ],
            'price' => 'required|numeric|min:0|max:99999999,99',
            'description' => 'nullable|sometimes|string',
            'is_active' => 'boolean'
        ];
    }
}
