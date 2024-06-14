<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\User;
use Illuminate\Http\Request;

class RegistrationController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'registrations' => 'required|array',
            'registrations.*.event_id' => 'required|exists:events,id',
            'email' => 'required|email',
        ]);

        $user = User::firstOrCreate(['email' => $request->email]);

        // Create mock events for testing
        $events = collect([
            (object)[
                'id' => 1,
                'name' => 'Event 1',
                'start_time' => '2024-06-15 10:00:00',
                'end_time' => '2024-06-15 12:00:00',
            ],
            (object)[
                'id' => 2,
                'name' => 'Event 2',
                'start_time' => '2024-06-16 14:00:00',
                'end_time' => '2024-06-16 16:00:00',
            ]
        ]);

        // Check for overlapping events using mock data
        if ($this->hasOverlappingEvents($events)) {
            return response()->json(['error' => 'You have selected overlapping events'], 400);
        }

        // Sync mock events with the user for testing
        foreach ($events as $event) {
            $user->events()->syncWithoutDetaching($event->id);
        }

        // Send the test email
        \Mail::to($user->email)->send(new \App\Mail\RegistrationSuccessful($user, $events));

        return response()->json(['message' => 'Registrations successful'], 201);
    }


    private function hasOverlappingEvents($events)
    {
        for ($i = 0; $i < count($events) - 1; $i++) {
            $currentEventEnd = $events[$i]->end_time;
            $nextEventStart = $events[$i + 1]->start_time;

            if ($currentEventEnd > $nextEventStart) {
                return true;
            }
        }

        return false;
    }

    private function sendRegistrationEmails($user, $events)
    {
        $adminEmail = 'sasmen70@gmail.com';

        Mail::to($user->email)->send(new RegistrationSuccessful($user, $events));

        Mail::to($adminEmail)->send(new RegistrationSuccessful($user, $events));
    }
}


