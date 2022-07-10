<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
            'name' => 'required|max:100|regex:/^.+@/i|unique:App\Models\User,name',
            'email' => 'bail|required|email|unique:App\Models\User,email',
            'password' => ['bail','required',Password::min(8)->letters()
            ->mixedCase()
            ->numbers()
            ->symbols()
            ->uncompromised()],
            'confirm' => 'bail|same:password',

        ];
    }

    /**
    * Get the error messages for the defined validation rules.
    *
    * @return array
    */
    public function messages()
    {
        return [
        'username.required' => 'A username is required',
        'username.max' => 'The username must have in max 100 characters',
        'username.unique' => 'This username has already been taken',
        'email.required' => 'An email is required',
        'email.email' => 'Type a valid email',
        'email.unique' => 'This email was already registed',
        'password.required' => 'A password is required',
        'confirm.same' => 'The confirmation password and password must match.',

        ];
    }
}
