<?php
namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\RegistrationSuccessful;
use Illuminate\Support\Facades\DB;

class RegistrationController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'registrations' => 'required|array',
            'registrations.*.event_id' => 'required|exists:events,id',
            'email' => 'required|email',
        ]);

        // Check for overlapping events
        $selectedEventIds = collect($request->registrations)->pluck('event_id');
        $events = Event::whereIn('id', $selectedEventIds)->orderBy('start_time')->get();

        if ($this->hasOverlappingEvents($events)) {
            return response()->json(['error' => 'You have selected overlapping events'], 400);
        }

        // Store each registration
        foreach ($selectedEventIds as $eventId) {
            DB::table('registrations')->insert([
                'event_id' => $eventId,
                'email' => $request->email,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // Send registration emails
        $user = (object) ['email' => $request->email];
        $this->sendRegistrationEmails($user, $events);

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

    public function sendTestEmail()
    {
        $user = (object) ['email' => 'your_email@domain.com', 'name' => 'Test User'];
        $events = [
            (object) ['name' => 'Event 1', 'start_time' => '2024-06-20 10:00:00', 'end_time' => '2024-06-20 11:00:00'],
            (object) ['name' => 'Event 2', 'start_time' => '2024-06-21 12:00:00', 'end_time' => '2024-06-21 13:00:00']
        ];

        $this->sendRegistrationEmails($user, $events);

        return 'Test email has been sent!';
    }

    private function sendRegistrationEmails($user, $events)
    {
        $adminEmail = 'sasmen70@gmail.com';

        Mail::to($user->email)->send(new RegistrationSuccessful($user, $events));
        Mail::to($adminEmail)->send(new RegistrationSuccessful($user, $events));
    }
}
