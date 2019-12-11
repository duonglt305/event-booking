<?php


namespace DG\Dissertation\Admin\Http\Requests;


use Illuminate\Foundation\Http\FormRequest;

class UpdateSpeaker extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'update_firstname' => ['required', 'string'],
            'update_lastname' => ['required', 'string'],
            'update_photo' => ['nullable','mimes:png,jpg,jpeg'],
            'update_company' => ['required', 'string'],
            'update_position' => ['required', 'string'],
            'update_description' => ['nullable', 'string']
        ];
    }

    public function attributes()
    {
        return [
        ];
    }

}
