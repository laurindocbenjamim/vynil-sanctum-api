<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PlaylistRequest extends FormRequest
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
            'name' => 'required|max:100|unique:App\Models\Playlist,name',
            'trackList.*' => 'required|string|distinct|min:1',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Type a name for playlist',
            'name.max' => 'Require not less then 100 character',
            'name.unique' => 'This playlist was registed yet.',
            'code_list.required' => 'A code of list is required',
            'userID.required' => 'User not identifyed',
            'userID.numeric' => 'Invalid user identity',
        ];
    }
}
