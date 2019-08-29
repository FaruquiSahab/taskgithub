<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StudentValidateRequest extends FormRequest
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
            'email' => [
                'required',
                'unique:students',
                'email'
            ],
            'name' => [
                'required',
                'regex:/^[a-zA-Z ]+$/',
                'min:3',
                'max:20'
            ],
            'address' => [
                'required',
                'regex:/^[a-zA-Z0-9_\- ]+$/',
                'min:20',
                'max:50'
            ],
            'father_name'  => [
                'required',
                'regex:/^[a-zA-Z ]+$/',
                'min:3',
                'max:20'
            ],
            'date_of_birth' => 'required',
            'file_path' => [
                'required',
                'mimes:PDF'
            ],
        ];
    }
}
