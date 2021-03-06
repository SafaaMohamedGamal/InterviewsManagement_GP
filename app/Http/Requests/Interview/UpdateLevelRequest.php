<?php

namespace App\Http\Requests\Interview;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateLevelRequest extends FormRequest
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
        $level = request()->level;
        return [
            'name' => [
                'min:2',
                Rule::unique('levels')->ignore($level->name, 'name'),
            ],
        ];
    }
}
