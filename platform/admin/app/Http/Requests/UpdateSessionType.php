<?php

namespace DG\Dissertation\Admin\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSessionType extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'session_type_name' => ['required', 'string'],
            'session_type_cost' => ['nullable', 'integer']
        ];
    }


    public function attributes()
    {
        return [
            'session_type_name' => 'name',
            'session_type_cost' => 'cost',
        ];
    }

}
