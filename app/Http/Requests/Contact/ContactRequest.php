<?php

namespace App\Http\Requests\Contact;

use Illuminate\Foundation\Http\FormRequest;

class ContactRequest extends FormRequest
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
            'contact_types_id' => 'exists:App\ContactType,id'
        ];
    }


    public function messages()
    {
        return [
            'contact_types_id' => "this way of contact doesn't exist"
        ];
    }
}
