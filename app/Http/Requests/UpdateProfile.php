<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProfile extends FormRequest
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
            // 'birth_year' => 'required|integer|min:1900|max:'.date("Y"),
            // 'gender' => 'required|integer',
            // 'phone_number' => 'required|digits_between:5,15',
            // 'photo' => 'required',
            'language.id' => 'required',
            'city.id' => 'required',
        ];
    }
}
