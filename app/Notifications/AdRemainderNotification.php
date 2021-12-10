<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Ad;

class AdRemainderNotification extends Notification
{
    use Queueable;
    public $ad;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
     public function __construct(Ad $ad)
     {
         $this->ad = $ad;
     }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
      $greeting = sprintf('Remainder your ad ' . $this->ad->title . ' will be publish next day at ' . $this->ad->start_date);
        return (new MailMessage)
                      ->subject('Remainder your ad ' . $this->ad->title . ' will be publish next day at ' . $this->ad->start_date)
                      ->greeting($greeting)
                      ->line('Thank you.');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
