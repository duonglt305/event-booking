<?php


namespace DG\Dissertation\Api\Mails;

use DG\Dissertation\Api\Models\Attendee;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NewAttendeeVerifyCode extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    /**
     * @var $verificationCode
     */
    protected $verificationCode;
    protected $attendee;

    public function __construct(Attendee $attendee, string $verificationCode)
    {
        $this->attendee = $attendee;
        $this->verificationCode = $verificationCode;
    }


    public function build()
    {
        return $this->view('api::mails.verify')
            ->subject('Verify your account - Event Booking Platform')
            ->with([
                'attendee' => $this->attendee,
                'verification_code' => $this->verificationCode
            ]);
    }
}
