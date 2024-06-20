<?php


namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class RegistrationSuccessful extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $events;

    public function __construct($user, $events)
    {
        $this->user = $user;
        $this->events = $events;
    }

    public function build()
    {
        return $this->from('from@example.com', 'NConnect')
            ->subject('Registration Successful')
            ->view('emails.registration-successful');
    }
}
