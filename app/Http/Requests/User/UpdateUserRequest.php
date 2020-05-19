<?php

namespace App\Http\Requests\User;

use App\User;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;

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
        $user = User::find(Request()->user);
        return [
            'name' => [
                Rule::unique('users')->ignore($user->name, 'name'),
            ],
            'email' => [
                Rule::unique('users')->ignore($user->email, 'email'),
            ],
            'password' => 'confirmed',
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
