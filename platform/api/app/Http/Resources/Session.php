<?php


namespace DG\Dissertation\Api\Http\Resources;

use DG\Dissertation\Api\Http\Resources\Speaker as SpeakerResource;
use DG\Dissertation\Api\Http\Resources\SessionType as SessionTypeResource;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property int id
 * @property string description
 * @property string title
 * @property \DateTime start_time
 * @property \DateTime end_time
 * @property int|null cost
 * @property \DG\Dissertation\Api\Models\Speaker speaker
 * @property \DG\Dissertation\Api\Models\SessionType sessionType
 */
class Session extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'speaker' => new SpeakerResource($this->speaker),
            'start' => $this->start_time,
            'end' => $this->end_time,
            'type' => $this->sessionType->name,
            'cost' => $this->sessionType->cost,
        ];
    }
}
