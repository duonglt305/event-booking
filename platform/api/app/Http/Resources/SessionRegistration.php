<?php


namespace DG\Dissertation\Api\Http\Resources;


use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property int session_id
 * @property int registration_id
 * @property mixed attended_at
 */
class SessionRegistration extends JsonResource
{
    public function toArray($request)
    {
        return $this->session_id;
    }
}
