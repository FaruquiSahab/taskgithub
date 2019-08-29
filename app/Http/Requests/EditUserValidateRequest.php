<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EditUserValidateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => [
                'required',
                'regex:/^[a-zA-Z ]+$/',
                'min:3',
                'max:20'
            ],
            'password' => [
                'required',
                'string',
                'min:6',
                'max:20',
                'confirmed'
            ],
            'password_confirmation' => [
                'required',
                'string',
                'min:6',
                'max:20'
            ],
            'old_password'  => [
                'required',
                'min:6',
                'max:20'
            ],
        ];
    }

}
