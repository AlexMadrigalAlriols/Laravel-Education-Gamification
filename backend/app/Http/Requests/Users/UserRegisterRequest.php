<?php

namespace App\Http\Requests\Users;

use Illuminate\Foundation\Http\FormRequest;

class UserRegisterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    public function attributes() {
        return [
            'email' => 'Correo Electronico',
            'password' => 'Password',
        ];
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array {
        return [
            'nick'  => 'required|unique:users',
            'name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email|unique:users',
            'college'=> 'required',
            'password' => 'required|confirmed|min:6'
        ];
    }

    public function messages() {
        return [
            'email.required' => 'El :attribute es obligatorio.',
            'password.required' => 'El :attribute es obligatorio.',
        ];
    }
}