<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoginPasswordRequest extends FormRequest
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
            'userEmail' => 'required|email',
            'password' => 'required|string'
        ];
    }

    public function messages(){
        return [
            'userEmail.required' => 'This field is required.',
            'userEmail.email' => 'Type a valid email.',
            'password.required' => 'This field is required.',
        ];
    }
}
