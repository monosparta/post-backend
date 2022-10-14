<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class StoreOrUpdateUserOrganizationRequest extends FormRequest
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
            'name' => 'required|string',
            'vat' => 'nullable|string',
            'phone_country_code' => ['required', 'string', 'min:1', 'max:4'],
            'phone_country_calling_code' => ['required', 'string', 'min:1', 'max:5'],
            'phone' => 'required|string|min:8|max:20',
            'email' => 'required|string',
            'address.city' => 'sometimes|required_with:street|string',
            'address.zip_code' => 'sometimes|nullable|string',
            'address.region' => 'sometimes|nullable|string',
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
