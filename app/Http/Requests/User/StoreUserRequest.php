<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
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
            'name' => 'required|unique:App\User,name',
            'email' => 'required|unique:App\User,email',
            'password' => 'required|confirmed',
            'phone' => 'required|regex:/^\+[(]{0,1}[0-9]{1,4}[)]{0,1}[0-9]{11}$/i'
        ];
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function messages()
    {
        return [
            'name.unique' => "name must be unique",
            'name.required' => "name is required",
            'email.unique' => "email must be unique",
            'email.required' => "email is required",
            'password.confirmed' => "password doesn't match password confirmation",
            'phone.required' => "phone is required",
            'phone.regex' => "phone syntax in incorrect ex:[+(02)012334455]",
        ];
    }
}
