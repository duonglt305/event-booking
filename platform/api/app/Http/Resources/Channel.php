<?php


namespace DG\Dissertation\Api\Http\Resources;

use DG\Dissertation\Api\Http\Resources\Room as RoomResource;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property int id
 * @property string name
 * @property mixed rooms
 */
class Channel extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'rooms' => RoomResource::collection($this->rooms)
        ];
    }
}
