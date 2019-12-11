<?php


namespace DG\Dissertation\Api\Http\Resources;


use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property string name
 * @property integer|null cost
 */
class SessionType extends JsonResource
{
    public function toArray($request)
    {
        return [
            'name' => $this->name,
            'cost' => intval($this->cost) === 0 ? null : $this->cost,
        ];
    }
}
