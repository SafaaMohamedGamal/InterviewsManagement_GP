<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
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
            'name' => 'unique:App\User,name',
            'email' => 'unique:App\User,email',
            'password' => 'required|confirmed',
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
            'email.unique' => "email must be unique",
            'password.confirmed' => "password doesn't match password confirmation",
        ];
    }
}
