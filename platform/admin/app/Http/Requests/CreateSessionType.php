<?php

namespace DG\Dissertation\Admin\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateSessionType extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => ['required', 'string'],
            'cost' => ['nullable', 'integer']
        ];
    }


    public function attributes()
    {
        return [
            'name' => 'name',
            'cost' => 'cost',
        ];
    }

}
