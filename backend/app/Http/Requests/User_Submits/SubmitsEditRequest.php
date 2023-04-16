<?php

namespace App\Http\Requests\User_Submits;

use Illuminate\Foundation\Http\FormRequest;

class SubmitsEditRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'id_users_submits' => 'required',
            'id_tasks' => '',
            'id_user' => '',
            'submit' => '',
            'mark' => '',
        ];
    }
}
