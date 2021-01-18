<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class OrganizationUserRegistration extends FormRequest
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
            'name' => 'required|string',
            'email' => 'required|string|email|max:255|unique:users',
            'birth_year' => 'required|integer|min:1900|max:'.date("Y"),
            'gender' => 'required|boolean',
            'phone_number' => 'required|digits_between:5,15',
            'language.id' => 'required',
            'city.id' => 'required',
        ];
    }
}
