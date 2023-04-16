<?php

namespace App\Http\Requests\Tasks;

use Illuminate\Foundation\Http\FormRequest;

class TasksEditRequest extends FormRequest
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
            'id_task'   => 'required',
            'id_category'  => '',
            'type' => '',
            'title' => '',
            'description' => '',
            'limit_date' => '',
            "percentage" => '',
            "max_mark" => ''
        ];
    }
}
