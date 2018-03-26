<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AnonymizationRequest extends FormRequest
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
        return [
            'date' => 'date_equals:' . \Auth::user()->birthdate
        ];
    }

    public function  messages()
    {
        return [
            'date.date_equals' => __("Dates doesn't match")
        ];
    }
}
