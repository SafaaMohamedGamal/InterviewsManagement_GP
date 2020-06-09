<?php

namespace App\Http\Requests\Job;

use Illuminate\Foundation\Http\FormRequest;

class UpdateJobRequest extends FormRequest
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
     * @return array
     */
    public function rules()
    {
        return [
            'title' => 'string|min:5|max:40',
            'description'=>'string|min:10',
            'seniority'=>'string|min:4|max:25',
            'years_exp'=>'integer|min:0',
            'requirements'=>'required|array',
            'requirements.*'=>'filled|distinct'
        ];
    }
}
