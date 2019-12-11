<?php


namespace DG\Dissertation\Api\Http\Resources;


use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property int id
 * @property string name
 * @property int|null cost
 * @property boolean available
 * @property string|null describe
 * @property string|null description
 * @property bool feature
 */
class Ticket extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->describe,
            'short_description' => $this->description,
            'feature' => $this->feature,
            'cost' => intval($this->cost) === 0 ? null : $this->cost,
            'available' => $this->available,
        ];
    }
}
