<?php


namespace DG\Dissertation\Api\Http\Resources;


use Illuminate\Http\Resources\Json\JsonResource;

class Partner extends JsonResource
{
    public function toArray($request)
    {
        return [
            'name' => $this->name,
            'logo' => asset($this->logo),
            'description' => $this->description,
        ];
    }
}
