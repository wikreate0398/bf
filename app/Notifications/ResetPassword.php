<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class ResetPassword extends Notification
{
    use Queueable;

    private $new_pass;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($new_pass)
    {
        $this->new_pass = $new_pass;
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
                    ->greeting("Hello {$notifiable->name}!")
                    ->line(new \Illuminate\Support\HtmlString('Your new password <b>' . $this->new_pass.'</b>'));
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
