<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class NewItemInCart extends Notification
{
    use Queueable;

    private $auction;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($auction)
    {
        $this->auction = $auction;
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
        $subject = sprintf('You\'ve got a new message from %s!', config('app.name'));

        return (new MailMessage)
            ->subject($subject)
            ->from(\Constant::get('EMAIL'))
            ->greeting("Congratulations {$notifiable->name}!")
            ->line('You have received a new item in the cart')
            ->line('Thank you for using our application!');
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
