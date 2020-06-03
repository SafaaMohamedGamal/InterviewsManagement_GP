<?php

namespace App\Http\Requests\Application;

use Illuminate\Foundation\Http\FormRequest;

class StoreStatusRequest extends FormRequest
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
            'name'=>[
                'required',
                'unique:app_statuses,name,'.$this->appstatus->id
            ],
            'description'=>[
                'required',
                'unique:app_statuses,description,'.$this->appstatus->id
            ],

        ];
    }
}
