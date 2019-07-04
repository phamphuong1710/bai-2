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
            'name' => 'required',
            'email' => 'required|unique:users',
            'password' => 'required',
            'password_confirmation' => 'required_with:password|same:password'
        ];
    }

    public function messages()
    {
        return [
            'email.required' => 'A email is required',
            'name.required' => 'A name is required',
            'email.unique' => 'A email is unique',
            'password.required' => 'A password is required',
            'password_confirmation.required' => 'A Confirm Password is required',
            'password_confirmation.same' => 'Password ang Confirm Password must be same'
        ];
    }
}
