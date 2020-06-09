<?php

namespace App\Http\Requests\Seeker;

use Illuminate\Foundation\Http\FormRequest;

class StoreSeekerRequest extends FormRequest
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
            'name' => 'required|alpha|unique:App\User,name',
            'email' => 'required|email|unique:App\User,email',
            'password' => 'required|confirmed',
            'address' => ['nullable', 'string'],
            'city' => ['nullable', 'alpha'],
            'seniority' => ['nullable', 'alpha'],
            'expYears' => ['nullable', 'numeric'],
            'currentJob' => ['nullable', 'alpha'],
            'currentSalary' => ['nullable', 'numeric'],
            'expectedSalary' => ['nullable', 'numeric'],
            'cv' => ['nullable', 'file', 'mimes:pdf'],
            'phone' => 'required|regex:/^\+[0-9]{1,4}[0-9]{11}$/i'
          ];
    }

    public function messages()
    {
        return [
            'name.unique' => "name must be unique",
            'name.required' => "name is required",
            'email.unique' => "email must be unique",
            'email.required' => "email is required",
            'password.confirmed' => "password doesn't match password confirmation",
            'phone.required' => "phone is required",
            'phone.regex' => "phone syntax is incorrect ex:[+0201233445509]",
        ];
    }
}
