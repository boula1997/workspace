<?php

namespace App\Http\Requests\Dashboard;

use Illuminate\Foundation\Http\FormRequest;

class HistoryRequest extends FormRequest
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
        'task_id' => 'required',

        'employee_id' => 'required',

        'action' => 'required',
        ];
        
        return  $rules;
    }

}
