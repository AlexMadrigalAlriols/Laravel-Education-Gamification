<?php

namespace App\Http\Requests\Popers;

use Illuminate\Foundation\Http\FormRequest;

class PoperCreateRequest extends FormRequest
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
            'poper_name'  => 'required|min:4|max:20',
            'skin' => 'required',
            'stats'=> 'required',
            'element' => 'required'
        ];
    }
}
