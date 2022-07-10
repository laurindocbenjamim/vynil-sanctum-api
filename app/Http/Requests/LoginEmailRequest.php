<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoginEmailRequest extends FormRequest
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
            'email' => 'required|email'
        ];
    }

    public function messages(){
        return [
            'email.required' => 'This field is required.',
            'email.email' => 'Type a valid email.'
        ];
    }
}
