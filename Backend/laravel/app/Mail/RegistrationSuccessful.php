<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

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
        $token = Str::random(60);
        $expiry = Carbon::now()->addHours(24); // Token valid for 24 hours

        DB::table('registration_tokens')->insert([
            'email' => $this->user->email,
            'token' => $token,
            'expires_at' => $expiry,
        ]);

        $cancellationLink = url('api/cancel-registration?token=' . $token);

        return $this->from('from@example.com', 'NConnect')
            ->subject('Registration Successful')
            ->view('emails.registration-successful')
            ->with([
                'cancellationLink' => $cancellationLink,
            ]);
    }
}
