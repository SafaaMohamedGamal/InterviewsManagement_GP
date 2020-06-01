<?php

namespace App\Http\Requests\Contact;

use App\Contact;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateContactRequest extends FormRequest
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
        $contact = request()->contact;
        return [
            'data' => [
                'required',
                Rule::unique('contacts')->ignore($contact->data, 'data'),
            ],
            'seeker_id' => 'exists:App\User,id',
            'contact_types_id' => 'exists:App\ContactType,id',
        ];
    }


    public function messages()
    {
        return [
            'data.unique' => "this contact is already used",
            'contact_types_id' => "this way of contact doesn't exist",
        ];
    }
}
