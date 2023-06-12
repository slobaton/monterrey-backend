<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
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
            'name'             => 'required|string|max:255',
            'paternal_surname' => 'required_without:maternal_surname|string|max:255',
            'maternal_surname' => 'required_without:paternal_surname|string|max:255',
            'username'         => 'required|string|max:255|unique:App\Models\User,username',
            'email'            => 'required|email|max:255|unique:App\Models\User,email',
            'password'         => 'required|confirmed',
        ];
    }
}
