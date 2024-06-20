<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Mail;
use App\Mail\RegistrationSuccessful;

Route::get('/send-test-email', function () {
    $user = (object) ['email' => 'test@example.com', 'name' => 'Test User'];
    $events = [
        (object) ['name' => 'Event 1', 'start_time' => '2024-06-20 10:00:00', 'end_time' => '2024-06-20 11:00:00'],
        (object) ['name' => 'Event 2', 'start_time' => '2024-06-21 12:00:00', 'end_time' => '2024-06-21 13:00:00']
    ];

    Mail::to($user->email)->send(new RegistrationSuccessful($user, $events));

    return 'Test email has been sent!';
});
