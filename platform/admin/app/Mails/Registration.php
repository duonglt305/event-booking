<?php


namespace DG\Dissertation\Admin\Mails;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class Registration extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    /**
     * @var $verificationCode
     */
    protected $data;

    public function __construct($data)
    {
        $this->data = $data;
    }


    public function build()
    {
        return $this->view('admin::mails.registration',['name' => 'Giang'])
            ->subject('New Registration - Event Booking Platform');
    }
}
