<?php


namespace DG\Dissertation\Api\Http\Resources;


use Illuminate\Http\Resources\Json\JsonResource;
use DG\Dissertation\Api\Http\Resources\Organizer as OrganizerResource;

/**
 * @property int id
 * @property string name
 * @property string slug
 * @property string address
 * @property string thumbnail
 * @property string description
 * @property mixed date
 * @property \DG\Dissertation\Api\Models\Organizer organizer
 */
class Event extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'slug' => $this->slug,
            'date' => $this->date,
            'address' => $this->address,
            'thumbnail' => asset($this->thumbnail),
            'description' => $this->description,
            'organizer' => new OrganizerResource($this->organizer),
        ];
    }
}
