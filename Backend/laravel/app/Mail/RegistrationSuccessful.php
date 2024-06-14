<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class RegistrationSuccessful extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $events;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user, $events)
    {
        $this->user = $user;
        $this->events = $events;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $fromAddress = 'default@yourdomain.com';
        if (str_ends_with($this->user->email, '@student.ukf.sk')) {
            $fromAddress = 'miroslav.majersky@student.ukf.sk';
        }

        return $this->from($fromAddress)
            ->subject('Registration Successful')
            ->view('emails.registration-successful');
    }
}
