<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class StoreUserRequest extends FormRequest
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
            'custom_id' => 'required|string|max:10|unique:users,custom_id',
            'username' => 'required|string|unique:users,name',
            'full_name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'mobile_country_code' => 'required|string|max:2',
            'mobile_country_calling_code' => 'required|string|max:6',
            'mobile' => 'string|min:7|max:20|unique:users,mobile',
            'password' => 'required|min:6',
            'confirm_password' => 'required|same:password',
        ];
    }

    public function message()
    {
        return [
            'email.required' => 'Email is required',
            'email.unique' => 'Email is already taken',
            'username.required' => 'Username is required',
            'password.required' => 'Password is required',
            'password.min' => 'Password must be at least 6 characters',
            'mobile.string' => 'Mobile must be a string',
            'mobile.min' => 'Mobile must be at least 8 characters',
            'mobile.max' => 'Mobile must be at most 11 characters',
            'mobile.unique' => 'Mobile is already taken',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'success' => false,
            'message' => $validator->errors(),
        ], 422));
    }
}
