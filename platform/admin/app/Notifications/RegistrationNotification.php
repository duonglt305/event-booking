<?php

namespace DG\Dissertation\Admin\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class RegistrationNotification extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * @var array
     */
    private $data;

    /**
     * Create a new notification instance.
     * @param $data
     * @return void
     */
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database', 'mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param mixed $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $total = intval($this->data['ticket']->cost);
        if(!empty($this->data['sessions'])){
            foreach ($this->data['sessions'] as $session){
                if(intval($session->sessionType->cost) > 0) $total +=intval($session->sessionType->cost);
            }
        }
        return (new MailMessage)
            ->view('admin::mail.registration', [
                'data' => $this->data,
                'total' => $total
            ])
            ->subject('New Registration - Event Booking Platform');


    }

    /**
     * Get the array representation of the notification.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {

        return $this->data;
    }
}
