<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class ConfirmRegistration extends Notification
{
    use Queueable;

    private $confirmation_link;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($confirm_hash)
    {
        $this->confirmation_link = url(route('registration_confirm', ['lang' => \App::getLocale(), 'confirmation_hash' => $confirm_hash]));
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
                    ->line('Welcome to our portal. Confirm your account')
                    ->action('Confirm', $this->confirmation_link)
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
