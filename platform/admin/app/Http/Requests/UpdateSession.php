<?php

namespace DG\Dissertation\Admin\Http\Requests;

use Carbon\Carbon;
use DG\Dissertation\Admin\Models\Room;
use DG\Dissertation\Admin\Models\Session;
use DG\Dissertation\Admin\Repositories\EventRepository;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

/**
 * @property \Illuminate\Http\UploadedFile $thumbnail
 * @property string $slug
 */
class UpdateSession extends FormRequest
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
     * @param $eventRepository
     * @return array
     */
    public function rules(EventRepository $eventRepository)
    {
        $event = $eventRepository->findById($this->event);

        $rule = [
            'session_title' => ['required', 'string'],
            'session_session_type_id' => ['required', 'exists:session_types,id'],
            'session_speaker_id' => ['required', 'exists:speakers,id'],
            'session_room_id' => ['required', 'exists:rooms,id'],
            'session_start_time' => ['required', 'string', 'date_format:d/m/Y H:i', 'after_or_equal:'. $event->date],
            'session_end_time' => ['required', 'string', 'date_format:d/m/Y H:i', 'after:start_time'],
            'session_description' => ['nullable', 'string']
        ];

        if (!empty($this->request->get('session_room_id')) &&
            !empty($this->request->get('session_start_time')) &&
            !empty($this->request->get('session_end_time'))) {

            $sessionModel = Session::find($this->session_id);
            $postStartTime = str_replace('/', '-', $this->request->get('session_start_time'));
            $postEndTime = str_replace('/', '-', $this->request->get('session_end_time'));

            /* if have change time range*/
            if (!$this->compareTime(
                $sessionModel->start_time,
                $sessionModel->end_time,
                $postStartTime,
                $postEndTime
            )) {
                $postStartTime = Carbon::parse($postStartTime)->addMinutes(1);
                $postEndTime = Carbon::parse($postEndTime)->subMinutes(1);

                if (!is_null($this->checkInPostTimeRange($postStartTime, $postEndTime))) {
                    $isExists = true;
                } else {
                    $isExists = $this->checkConflictWithOtherSession($sessionModel, $postStartTime, $postEndTime);
                }
                if ($isExists) {
                    $rule['session_start_time'][] = function ($attribute, $value, $fail) {
                        $fail('This time is already has session registered');
                    };
                    $rule['session_end_time'][] = function ($attribute, $value, $fail) {
                        $fail('This time is already has session registered');
                    };
                }
            }
        }
        return $rule;
    }

    /**
     * @param $start
     * @param $end
     * @param $_start
     * @param $_end
     * @return bool
     */
    private function compareTime($start, $end, $_start, $_end)
    {
        $start = Carbon::parse($start);
        $end = Carbon::parse($end);
        $_start = Carbon::parse($_start);
        $_end = Carbon::parse($_end);
        return $start->equalTo($_start) && $end->equalTo($_end);
    }

    /**
     * @param $postStartTime
     * @param $postEndTime
     * @return mixed
     */
    private function checkInPostTimeRange($postStartTime, $postEndTime)
    {
        return Room::find($this->request->get('session_room_id'))
            ->sessions()
            ->where(function ($query) use ($postEndTime, $postStartTime) {
                return $query->whereBetween(
                    'sessions.start_time',
                    [$postStartTime->toDateTimeString(), $postEndTime->toDateTimeString()]
                );
            })
            ->orWhere(function ($query) use ($postEndTime, $postStartTime) {
                return $query->whereBetween(
                    'sessions.end_time',
                    [$postStartTime->toDateTimeString(), $postEndTime->toDateTimeString()]
                );
            })
            ->whereNotIn('id', [$this->request->get('session')])
            ->first();
    }

    /**
     * @param $model
     * @param $postStartTime
     * @param $postEndTime
     * @return bool
     */
    private function checkConflictWithOtherSession($model, $postStartTime, $postEndTime)
    {
        $isExists = false;
        $sessions = Room::find($this->request->get('session_room_id'))
            ->sessions()
            ->whereNotIn('id', [$model->id])
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
            'session_title' => 'title',
            'session_session_type_id' => 'session_type',
            'session_speaker_id' => 'speaker',
            'session_room_id' => 'room',
            'session_start_time' => 'start time',
            'session_end_time' => 'end time',
            'session_description' => 'description'
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
