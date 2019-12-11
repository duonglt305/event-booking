<?php


namespace DG\Dissertation\Api\Events;


use DG\Dissertation\Api\Models\Attendee;
use Illuminate\Queue\SerializesModels;

class Registered
{
    use SerializesModels;


    /**
     * @var Attendee
     */
    public $attendee;

    public function __construct(Attendee $attendee)
    {
        $this->attendee = $attendee;
    }
}
