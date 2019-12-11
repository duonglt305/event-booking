<?php


namespace DG\Dissertation\Api\Http\Resources;


use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property string firstname
 * @property string lastname
 * @property string photo
 * @property string company
 * @property string description
 * @property mixed position
 */
class Speaker extends JsonResource
{
    public function toArray($request)
    {
        return [
            'firstname' => $this->firstname,
            'lastname' => $this->lastname,
            'photo' => asset($this->photo),
            'company' => $this->company,
            'description' => $this->description,
            'position' => $this->position
        ];
    }
}
