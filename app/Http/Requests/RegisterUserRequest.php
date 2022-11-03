<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterUserRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'password' => 'required|string|min:6',
            'phone_number' => 'required|string|max:255|unique:users',
            'city' => 'required|in:latakia,damascus,homs',
            'address' => 'required',
            'blood_type_id' => 'required',
            'national_number' => 'required|string',
            'sex' => 'required|in:female,male',
            'age' => 'required|integer|min:18',
            'weight' => 'required|integer',
        ];
    }
}
