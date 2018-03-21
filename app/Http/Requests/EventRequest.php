<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;

class EventRequest extends FormRequest
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
            'event.name' => 'required|max:255',
            'event.description' => 'max:511',
            'event.start_date' => 'required|date_format:d.m.Y',
            'event.start_time' => 'required',
            'event.end_time' => 'required',
            'event.end_date' => 'required|date_format:d.m.Y|after_or_equal:event.start_date',
            'event.register_deadline' => 'required|date_format:d.m.Y|before_or_equal:event.end_date',
            'place.name' => 'required|max:255',
        ];
    }

    /**
     * Handle a failed validation attempt.
     *
     * @param  \Illuminate\Contracts\Validation\Validator  $validator
     * @return void
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    protected function failedValidation(Validator $validator)
    {
        \Alert::error('Your event is ivalid!');

        throw (new ValidationException($validator))
                    ->errorBag($this->errorBag)
                    ->redirectTo($this->getRedirectUrl());
    }
}
