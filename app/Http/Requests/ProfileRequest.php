<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProfileRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return \Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $user_id = \Auth::user()->id;

        $rules = [
            'nick' => 'required|string|max:255|unique:users,nick,' . $user_id,
            'email' => 'required|string|email|max:255|unique:users,email,' . $user_id,
            'gender' => 'required|in:M,F',
            'birthdate' => 'required|date_format:d.m.Y',
        ];

        if(! empty($this->password))
            $rules['password'] = 'string|min:6|confirmed';

        return $rules;
    }
}
