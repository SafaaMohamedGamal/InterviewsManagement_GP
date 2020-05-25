<?php

namespace App\Http\Requests\Job;

use Illuminate\Foundation\Http\FormRequest;

class StoreJobRequest extends FormRequest
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
            'title' => 'required',
            'description'=>'required',
            'seniority'=>'required',
            'years_exp'=>'required|integer|min:0',
            'requirements'=>'required|array',
            'requirements.*'=>'filled|distinct'
        ];
    }
}
