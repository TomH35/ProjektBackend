<?php
namespace App\Http\Controllers;

use Illuminate\Support\Facades\Mail;
use App\Mail\RegistrationSuccessful;
use Illuminate\Support\Facades\Log;

class TestMailController extends Controller
{
    public function sendTestEmail()
    {
        $user = (object) [
            'name' => 'Test User',
            'email' => 'miro@student.ukf.sk'
        ];

        $events = [
            (object) ['name' => 'Test Event 1'],
            (object) ['name' => 'Test Event 2']
        ];

        try {
            Mail::to($user->email)->send(new RegistrationSuccessful($user, $events));
            return response()->json(['message' => 'Test email sent successfully!']);
        } catch (\Exception $e) {
            Log::error('Failed to send test email', ['error' => $e->getMessage()]);
            return response()->json(['error' => 'Failed to send test email'], 500);
        }
    }
}
