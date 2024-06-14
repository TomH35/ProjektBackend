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

        $selectedEvents = collect($request->registrations)->pluck('event_id');
        $events = Event::whereIn('id', $selectedEvents)->orderBy('start_time')->get();

        if ($this->hasOverlappingEvents($events)) {
            return response()->json(['error' => 'You have selected overlapping events'], 400);
        }

        foreach ($selectedEvents as $eventId) {
            $user->events()->syncWithoutDetaching($eventId);
        }

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
}


