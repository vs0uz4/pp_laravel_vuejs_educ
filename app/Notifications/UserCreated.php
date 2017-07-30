<?php

namespace SiGeEdu\Notifications;

use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class UserCreated extends Notification
{
    /**
     * The password reset token.
     *
     * @var string
     */
    private $token;

    /**
     * Create a notification instance.
     *
     * @param  string  $token
     * @return void
     */
    public function __construct($token)
    {
        $this->token = $token;
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
        $appName = config('app.name');
        return (new MailMessage)
            ->subject('Your ' . $appName . ' account has been created')
            ->greeting('Hello ' . $notifiable->name . ', welcome to the ' . $appName)
            ->line('Your enrolment number is: ' . $notifiable->enrolment)
            ->action('Set your access password', route('auth.password.reset', $this->token))
            ->line('Thank you for using our application!');
    }

}
