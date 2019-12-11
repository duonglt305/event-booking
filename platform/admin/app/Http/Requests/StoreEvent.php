<?php

namespace DG\Dissertation\Admin\Http\Requests;

use Carbon\Carbon;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

/**
 * @property \Illuminate\Http\UploadedFile $thumbnail
 * @property string $slug
 */
class StoreEvent extends FormRequest
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

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => ['required', 'string'],
            'slug' => ['required', 'string', Rule::unique('events')->where(function ($query) {
                $query->where('organizer_id', \Auth::id());
            }), 'regex:/^[a-z0-9-]+(?:[a-z0-9]+)*$/'],
            'date' => ['required', 'date_format:d/m/Y H:i'],
            'address' => ['required', 'string', 'min:10'],
            'thumbnail' => ['required', 'file', 'image', 'mimes:jpg,png,jpeg,svg'],
            'description' => 'nullable|string'
        ];
    }


    public function validated()
    {
        $validated = parent::validated();
        $validated['date'] = Carbon::createFromFormat('d/m/Y H:i', $validated['date'])->toDateTimeString();
        return $validated;
    }
}
