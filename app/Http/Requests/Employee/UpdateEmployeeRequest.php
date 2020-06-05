<?php

namespace App\Http\Requests\Employee;

use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
use Illuminate\Foundation\Http\FormRequest;
use App\User;

class UpdateEmployeeRequest extends FormRequest
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
        $user = User::find(Request()->employee->id);
        return [
            'name' => [
                Rule::unique('users')->ignore($user->name, 'name'),
            ],
            'email' => [
                'email',
                Rule::unique('users')->ignore($user->email, 'email'),
            ],
            'password' => 'nullable|confirmed|min:7',
            'position' => ['nullable', 'alpha'],
            'branch' => ['nullable', 'alpha'],
        ];
    }
}
