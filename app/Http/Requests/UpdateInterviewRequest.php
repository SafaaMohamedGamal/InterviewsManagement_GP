<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateInterviewRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true ;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'application_id' => 'nullable|exists:App\Application,id',
            'emp_id' => 'nullable|numeric|exists:App\Employee,id',
            'level_id' => 'nullable|numeric|exists:App\Level,id',
            'date' => "nullable|date",
            'seeker_review' => 'nullable|alpha_num',
            'company_review' => 'nullable|alpha_num',
            'zoom' => 'nullable|url',            
        ];
    }

    public function messages()
    {
        return [
            // 'application_id.required' => "application id is required",
            'application_id.exists' => "no such application with that id",
            // 'emp_id.required' => "employee  is required",
            'emp_id.exists' => "no such employee with that id",
            // 'level_id.required' => "level id is required",
            'level_id.exists' => "no such level with that id",
        ];
    }
}
