<?php

namespace App;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ReminderMail extends Mailable
{
    use Queueable, SerializesModels;
    public $details;

    public function __construct($details)
    {
        $this->details = $details;
    }

    public function build()
    {
//        return $this->markdown('emails.reminder');
        return $this->view('emails.reminder')
            ->from('no-reply@zesco.co.zm', config('app.name'))
            ->subject($this->details['subject'])
            ->with('details', $this->details);
    }
}
