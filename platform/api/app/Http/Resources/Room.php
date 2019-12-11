<?php


namespace DG\Dissertation\Api\Http\Resources;

use DG\Dissertation\Api\Http\Resources\Session as SessionResource;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property int id
 * @property mixed sessions
 * @property string name
 */
class Room extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'sessions' => SessionResource::collection($this->sessions),
        ];
    }
}
