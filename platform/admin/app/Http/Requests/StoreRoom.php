<?php


namespace DG\Dissertation\Admin\Http\Requests;


use Illuminate\Foundation\Http\FormRequest;

class StoreRoom extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => ['required', 'string'],
            'capacity' => ['required', 'numeric', 'integer'],
            'channel_id' => ['required', 'numeric', 'integer', 'exists:channels,id']
        ];
    }


    public function attributes()
    {
        return [
            'channel_id' => 'channel'
        ];
    }

}
