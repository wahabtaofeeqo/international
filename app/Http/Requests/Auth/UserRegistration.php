<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class UserRegistration extends FormRequest
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
    //'birth_year' => 'required|integer|min:1900|max:'.date("Y")
    
    public function rules()
    {
        return [
            'gender' => 'required|boolean',
            'phone_number' => 'required|digits_between:5,15',
            'photo' => 'required',
            'language.id' => 'required',
            'city' => 'required',
        ];
    }
}
