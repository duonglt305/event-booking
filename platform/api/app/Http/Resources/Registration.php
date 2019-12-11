<?php


namespace DG\Dissertation\Api\Http\Resources;


use DG\Dissertation\Api\Http\Resources\Event as EventResource;
use DG\Dissertation\Api\Http\Resources\Session as SessionResource;
use DG\Dissertation\Api\Http\Resources\Ticket as TicketResource;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property int id
 * @property mixed event
 * @property string status
 * @property mixed sessions
 * @property mixed ticket
 */
class Registration extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'event' => new EventResource($this->event),
            'status' => ucfirst(strtolower($this->status)),
            'sessions' => SessionResource::collection($this->sessions),
            'ticket' => new TicketResource($this->ticket),
        ];
    }
}
