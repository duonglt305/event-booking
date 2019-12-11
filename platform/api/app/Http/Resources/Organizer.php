<?php


namespace DG\Dissertation\Api\Http\Resources;


use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property int id
 * @property string name
 * @property string slug
 * @property string website
 * @property string address
 * @property string phone
 * @property string email
 */
class Organizer extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'slug' => $this->slug,
            'website' => $this->website,
            'phone' => $this->phone,
            'email' => $this->email,
            'address' => $this->address,
        ];
    }
}
