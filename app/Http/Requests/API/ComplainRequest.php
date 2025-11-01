<?php

namespace App\Http\Requests\API;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;

class ComplainRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules()
    {
        return [
            'en' => 'required|array',
            'en.title' => 'required|string',
            'en.description' => 'required|string',
            
            'ar' => 'required|array',
            'ar.title' => 'required|string',
            'ar.description' => 'required|string',
            
            'repeat' => 'sometimes|integer|min:1',
        ];
    }

    /**
     * Handle a failed validation attempt.
     */
    protected function failedValidation(Validator $validator)
    {
        $response = failedResponse($validator->errors());
        throw new ValidationException($validator, $response);
    }
}
