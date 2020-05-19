<?php

namespace App\Http\Requests\Contact;

use App\ContactType;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateContactTypeRequest extends FormRequest
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
        $contact_type = ContactType::find(Request()->contact_type);
        return [
            'type' => [
                Rule::unique('contact_types')->ignore($contact_type->first()->type, 'type'),
            ],
        ];
    }


    public function messages()
    {
        return [
            'type.unique' => 'this type already exists',
        ];
    }
}
