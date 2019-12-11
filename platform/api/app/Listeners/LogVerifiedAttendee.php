<?php


namespace DG\Dissertation\Api\Listeners;


use DG\Dissertation\Api\Events\Verified;

class LogVerifiedAttendee
{
    public function handle(Verified $verified)
    {
        $verified->attendee->markEmailAsVerified();
    }
}
