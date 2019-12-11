<?php


namespace DG\Dissertation\Admin\Http\Requests;


use Illuminate\Foundation\Http\FormRequest;

class StoreSpeaker extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'firstname' => ['required', 'string'],
            'lastname' => ['required', 'string'],
            'photo' => ['required', 'file', 'mimes:png,jpg,jpeg'],
            'company' => ['required', 'string'],
            'position' => ['required', 'string'],
            'description' => ['nullable', 'string']
        ];
    }

    public function attributes()
    {
        return [
        ];
    }

}
