<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

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
            'name' => 'required|max:20|regex:/^.+@/i|unique:App\Models\User,name',
            'email' => 'bail|required|email|unique:App\Models\User,email',
            'password' => ['bail','required',Password::min(8)->letters()
            ->mixedCase()
            ->numbers()
            ->symbols()
            ->uncompromised()],
            'confirm' => 'bail|same:password',
            'upload_limit' => 'bail|required|numeric',
            'agree' => 'bail|boolean',
            'notify' => 'bail|boolean',
            'avatar.*' => 'nullable|file|distinct|mimes:png,jpg,jpeg,bmp|dimensions:max_width=200,max_height=200',
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
            'name.required' => 'A username is required',
            'name.max' => 'The username must have in max 20 characters',
            'name.unique' => 'This username has already been taken',
            'email.required' => 'An email is required',
            'email.email' => 'Type a valid email',
            'email.unique' => 'This email was already registed',
            'password.required' => 'A password is required',
            'confirm.same' => 'The confirmation password and password must match.',
            'upload_limit.required' => 'The limit of upload is required.',
            'upload_limit.numeric' => 'The limit of upload must be a numeric value.',
            'agree.boolean' => 'The agree field must be a boolean value.',
            'notify.boolean' => 'The notify field must be a boolean value.',
            'avatar.file' => 'The avatar field must be a file.',
            'avatar.distinct' => 'The avatar field has repeated file.',
            'avatar.mimes' => 'The avatar field accept BMP, JPG/JPEG or PNG format.',
            'avatar.dimensions' => 'The avatar field must have 200 of max width and height dimesion.',

        ];
    }
}
