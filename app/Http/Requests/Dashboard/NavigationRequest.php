<?php

namespace App\Http\Requests\Dashboard;

use Illuminate\Foundation\Http\FormRequest;

class NavigationRequest extends FormRequest
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
 
    public function rules()
    {
        //to add or remove input from request in validation class use $this->merge
        //  $this->merge(['user_id' => auth('api')->user()->id]);


        $rules = [
'link' => 'required',

'title' => 'required',

'user' => 'nullable',

'password' => 'nullable',
'category_id' => 'required'
        ];
        
        return  $rules;
    }

}
