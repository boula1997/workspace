<?php

namespace App\Http\Requests\API;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;

class ServiceRequestRequest extends FormRequest
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

    // Older clients (and the public site form) post the camelCase field name
    protected function prepareForValidation()
    {
        if ($this->has('serviceRequest') && !$this->has('service_request')) {
            $this->merge(['service_request' => $this->input('serviceRequest')]);
        }
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'string|required',
            'phone' => 'required',
            'email' => 'email|required',
            'serviceRequest' => 'string|required',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        $response = failedResponse($validator->errors());
        throw new ValidationException($validator,$response);
    }
}
