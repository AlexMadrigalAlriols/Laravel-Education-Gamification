<?php

namespace App\Http\Requests\Users;

use Illuminate\Foundation\Http\FormRequest;

class UserEditRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array {
        return [
            'id_user' => 'required',
            'name' => '',
            'last_name' => '',
            'nick' => '',
            'email' => '',
            'role' => '',
            'pepas' => '',
            'profile_img' => '',
            'id_poper' => '',
            'inventory' => '',
            'birth_date' => '',
        ];
    }
}