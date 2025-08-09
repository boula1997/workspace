<?php

namespace App\Http\Requests\Dashboard;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class DbcredentialRequest extends FormRequest
{
    /**
     * Determine if the dbcredential is authorized to make this request.
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
        // dd(request()->all());
        return [
            'db_host' => 'required',

            'db_name' => 'required',

            'db_password' => 'required',

            'db_username' => 'required',
        ];
    }
}
