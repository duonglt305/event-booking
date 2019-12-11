<?php


namespace DG\Dissertation\Api\Listeners;


use DG\Dissertation\Api\Events\Registered;
use DG\Dissertation\Api\Mails\NewAttendeeVerifyCode;

class SendEmailVerificationNotification
{
    public function handle(Registered $registered)
    {
        $verificationCode = $registered->attendee->createVerificationCode();
        \Mail::to($registered->attendee->email)
            ->queue(new NewAttendeeVerifyCode($registered->attendee, $verificationCode));
    }


}
