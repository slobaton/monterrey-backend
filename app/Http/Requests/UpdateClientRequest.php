<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateClientRequest extends FormRequest
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
            'id'                => 'required|uuid',
            'nit'               => [
                'nullable',
                'sometimes',
                'string',
                'max:20',
                Rule::unique('clients', 'nit')->ignore($this->request->get('id'), 'id')
            ],
            'name'              => 'required|string|max:255',
            'paternal_surname'  => 'required_without:maternal_surname|string|max:255',
            'maternal_surname'  => 'required_without:paternal_surname|string|max:255',
            'phone'             => 'nullable|sometimes|string|max:15',
            'cellphone'         => 'nullable|sometimes|string|max:15',
            'is_active'         => 'boolean'
        ];
    }
}
