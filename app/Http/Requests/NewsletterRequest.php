<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class NewsletterRequest extends FormRequest
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
        if ($this->has('newsletterEmail') && !$this->has('newsletter_email')) {
            $this->merge(['newsletter_email' => $this->input('newsletterEmail')]);
        }
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules= [
            'newsletter_email'=>'required|email',
        ];

        return $rules;
    }

}
