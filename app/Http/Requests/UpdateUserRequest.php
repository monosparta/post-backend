<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;

class UpdateUserRequest extends FormRequest
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
            'email' => ['required', 'email', Rule::unique('users', 'email')->ignore($this->user)],
            'username' => ['required', 'string', 'min:3', 'max:255', Rule::unique('users', 'name')->ignore($this->user)],
            'mobile_country_code' => ['required', 'string', 'min:1', 'max:4'],
            'mobile_country_calling_code' => ['required', 'string', 'min:1', 'max:5'],
            'mobile' => ['required', 'string', 'min:8', 'max:20', Rule::unique('users', 'mobile')->ignore($this->user)],
            'full_name' => 'required|string|max:255', 
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
