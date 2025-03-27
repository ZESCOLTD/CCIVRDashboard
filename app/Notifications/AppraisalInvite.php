<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class AppraisalInvite extends Notification
{
    use Queueable;
    private $name,$comment, $cc, $bcc;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($name,$comment, $cc, $bcc)
    {
        $this->name = $name;
        $this->comment = $comment;
        $this->cc = $cc;
        $this->bcc = $bcc;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param mixed $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Appraisal Invite')
            ->greeting('Hello ' . $this->name)
            ->line($this->comment)
            ->cc($this->cc)
            ->bcc($this->bcc)
            ->action('Login', url(config('app.url')))
            ->line('Thanks for your prompt attention to this matter,');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
