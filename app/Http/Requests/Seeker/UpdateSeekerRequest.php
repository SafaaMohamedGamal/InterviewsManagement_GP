<?php

namespace App\Http\Requests\Seeker;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSeekerRequest extends FormRequest
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
          'address' => ['nullable', 'string'],
          'city' => ['nullable', 'alpha'],
          'seniority' => ['nullable', 'alpha'],
          'expYears' => ['nullable', 'numeric'],
          'currentJob' => ['nullable', 'alpha'],
          'currentSalary' => ['nullable', 'numeric'],
          'expectedSalary' => ['nullable', 'numeric'],
          'cv' => ['nullable', 'file', 'mimes:pdf']
        ];
    }
}
