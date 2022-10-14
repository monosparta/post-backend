<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class StoreOrUpdateUserProfileRequest extends FormRequest
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
            'categories.id' => 'filled|integer',
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'middle_name' => 'nullable|string',
            'birth_date' => 'required|date',
            'gender' => 'required|integer',
            'description' => 'nullable|string',
            'birth_date' => 'required|date',
            'job_title' => 'required|string|max:255',
            'phone_country_code' => ['required', 'string', 'min:1', 'max:4'],
            'phone_country_calling_code' => ['required', 'string', 'min:1', 'max:5'],
            'phone' => 'nullable|string|min:8|max:20',
            'nationality' => 'required|string',
            'identity_code' => 'required|string',
            'address.city' => 'filled|nullable|string',
            'address.zip_code' => 'filled|nullable|string',
            'address.region' => 'filled|nullable|string',
            'address.address_line_1' => 'sometimes|nullable|string',
            'address.address_line_2' => 'sometimes|nullable|string',
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
