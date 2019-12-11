<?php


namespace DG\Dissertation\Admin\Http\Requests;


use Carbon\Carbon;
use DG\Dissertation\Admin\Services\EventService;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\UploadedFile;
use Illuminate\Validation\Rule;

/**
 * @property UploadedFile thumbnail
 * @property int id
 * @property string slug
 */
class UpdateEvent extends FormRequest
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
                $query->where('organizer_id', \Auth::id())
                    ->where('id', '<>', $this->event);
            }), 'regex:/^[a-z0-9-]+(?:[a-z0-9]+)*$/'],
            'date' => ['required', 'date_format:d/m/Y H:i'],
            'address' => ['required', 'string', 'min:10'],
            'thumbnail' => ['nullable', 'file', 'image', 'mimes:jpg,png,jpeg,svg'],
            'description' => 'nullable|string'
        ];
    }

    public function messages()
    {
        return [
            'required' => trans('admin::validation.required'),
            'string' => trans('admin::validation.string'),
            'unique' => trans('admin::validation.unique'),
            'date_format' => trans('admin::validation.date_format'),
            'file' => trans('admin::validation.file'),
            'min' => trans('admin::validation.min'),
            'regex' => trans('admin::validation.regex'),
        ];
    }

    public function validated()
    {
        $validated = parent::validated();
        $validated['date'] = Carbon::createFromFormat('d/m/Y H:i', $validated['date'])->toDateTimeString();
        return $validated;
    }
}
