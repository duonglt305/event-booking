<?php

namespace DG\Dissertation\Admin\Http\Requests;

use Carbon\Carbon;
use DG\Dissertation\Admin\Models\Room;
use DG\Dissertation\Admin\Repositories\EventRepository;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

/**
 * @property \Illuminate\Http\UploadedFile $thumbnail
 * @property string $slug
 */
class StoreSession extends FormRequest
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
     * @param  $eventRepository
     * @return array
     */
    public function rules(EventRepository $eventRepository)
    {
        $event = $eventRepository->findById($this->event);
        $rule = [
            'title' => ['required', 'string'],
            'session_type_id' => ['required', 'exists:session_types,id'],
            'speaker_id' => ['required', 'exists:speakers,id'],
            'room_id' => ['required', 'exists:rooms,id'],
            'start_time' => ['required', 'string', 'date_format:d/m/Y H:i', 'after_or_equal:'. $event->date],
            'end_time' => ['required', 'string', 'date_format:d/m/Y H:i', 'after:start_time'],
            'description' => ['nullable', 'string']
        ];

        if (!empty($this->request->get('room_id')) &&
            !empty($this->request->get('start_time')) &&
            !empty($this->request->get('end_time'))) {

            $postStartTime = Carbon::parse(str_replace('/', '-', $this->request->get('start_time')))->addMinutes(1);
            $postEndTime = Carbon::parse(str_replace('/', '-', $this->request->get('end_time')))->subMinutes(1);

            $isExits = $this->checkConflictWithOtherSession($postStartTime, $postEndTime);
            if ($isExits) {
                $rule['start_time'][] = function ($attribute, $value, $fail) {
                    $fail('This time is already has session registered');
                };
                $rule['end_time'][] = function ($attribute, $value, $fail) {
                    $fail('This time is already has session registered');
                };
            }
        }
        return $rule;
    }

    /**
     * @param $model
     * @param $postStartTime
     * @param $postEndTime
     * @return bool
     */
    private function checkConflictWithOtherSession(Carbon $postStartTime,Carbon $postEndTime)
    {
        $isExists = false;
        $sessions = Room::find($this->request->get('room_id'))
            ->sessions()
            ->get();
        foreach ($sessions as $session) {
            $startTime = Carbon::parse($session->start_time);
            $endTime = Carbon::parse($session->end_time);
            if ($postStartTime->between($startTime, $endTime) || $postEndTime->between($startTime, $endTime)) {
                $isExists = true;
                break;
            }
        }
        return $isExists;
    }

    /**
     * @return array
     */
    public function attributes()
    {
        return [
            'start_time' => 'Start time',
            'end_time' => 'End time'
        ];
    }

    /**
     * @return array
     */
    public function messages()
    {
        return [
            'after_or_equal' => ':attribute must be after or equal to event start date'
        ];
    }
}
