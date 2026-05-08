<?php

namespace App\Http\Requests\Dashboard;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AdminRequest extends FormRequest
{
    /**
     * Determine if the admin is authorized to make this request.
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
        $image=request()->isMethod('put')?'nullable':'nullable';
        // dd(request()->all());
        return [
            'image' => $image,
            'name' => 'required',
            'email' => ['nullable','email',Rule::unique('admins', 'email')->ignore($this->admin)],
            'phone' => 'nullable',
            'messanger_id' => 'nullable',

            'whatsapp' => 'nullable',
            'password' => 'nullable|same:confirm-password',
            'roles' => 'required'
        ];
    }
}
