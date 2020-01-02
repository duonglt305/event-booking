<?php


namespace DG\Dissertation\Api\Http\Resources;

use DG\Dissertation\Api\Http\Resources\Article as ArticleResource;
use DG\Dissertation\Api\Http\Resources\Channel as ChannelResource;
use DG\Dissertation\Api\Http\Resources\Organizer as OrganizerResource;
use DG\Dissertation\Api\Http\Resources\Partner as PartnerResource;
use DG\Dissertation\Api\Http\Resources\Speaker as SpeakerResource;
use DG\Dissertation\Api\Http\Resources\Ticket as TicketResource;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property int id
 * @property string name
 * @property string slug
 * @property string address
 * @property string description
 * @property mixed date
 * @property mixed organizer
 * @property mixed channels
 * @property mixed tickets
 * @property mixed articles
 * @property mixed partners
 * @property mixed speakers
 * @property mixed latest_articles
 * @property mixed registration
 */
class EventDetail extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'slug' => $this->slug,
            'date' => $this->date,
            'address' => $this->address,
            'description' => $this->description,
            'organizer' => new OrganizerResource($this->organizer),
            'channels' => ChannelResource::collection($this->channels),
            'tickets' => TicketResource::collection($this->tickets),
            'latest_articles' => ArticleResource::collection($this->latest_articles),
            'partners' => PartnerResource::collection($this->partners),
            'speakers' => SpeakerResource::collection(($this->speakers)),
            'registration' => auth('api')->check() ? $this->registration : null,
        ];
    }
}
