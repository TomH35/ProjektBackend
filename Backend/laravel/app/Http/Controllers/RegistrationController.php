<?php
namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\RegistrationSuccessful;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

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
            $event = Event::find($eventId);

            if ($event->registration_count >= $event->capacity) {
                return response()->json(['error' => 'Event capacity exceeded for event ID ' . $eventId], 400);
            }

            $user->events()->syncWithoutDetaching($eventId);

            $event->increment('registration_count');
        }

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

    public function getRegisteredUsers($eventId)
    {
        $users = DB::table('event_registrations')
            ->where('event_id', $eventId)
            ->join('users', 'event_registrations.user_id', '=', 'users.id')
            ->select('users.email')
            ->get();

        return response()->json($users);
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

    public function showCancelRegistrationForm(Request $request)
    {
        $token = $request->query('token');
        $tokenData = DB::table('registration_tokens')->where('token', $token)->first();

        if (!$tokenData || Carbon::now()->greaterThan($tokenData->expires_at)) {
            return response()->json(['error' => 'Invalid or expired token'], 400);
        }

        return view('emails.cancel-registration', ['token' => $token]);
    }

    public function cancelRegistration(Request $request)
    {
        $request->validate([
            'token' => 'required|string',
        ]);

        $token = $request->input('token');
        $tokenData = DB::table('registration_tokens')->where('token', $token)->first();

        if (!$tokenData || Carbon::now()->greaterThan($tokenData->expires_at)) {
            return response()->json(['error' => 'Invalid or expired token'], 400);
        }

        $user = User::where('email', $tokenData->email)->first();

        if (!$user) {
            return response()->json(['error' => 'User not found'], 404);
        }

        // Get all events the user is registered for
        $events = DB::table('event_registrations')->where('user_id', $user->id)->get();

        // Remove the user from the events
        DB::table('event_registrations')->where('user_id', $user->id)->delete();

        // Decrement the registration count for each event
        foreach ($events as $event) {
            Event::where('id', $event->event_id)->decrement('registration_count');
        }

        // Delete the user
        $user->delete();

        // Delete the token
        DB::table('registration_tokens')->where('token', $token)->delete();

        return response()->json(['message' => 'Registration cancelled successfully'], 200);
    }
}
