<!DOCTYPE html>
<html>
<head>
    <title>Registration Successful</title>
</head>
<body>
<h1>Thank you for registering!</h1>
<p>Hello {{ $user->name ?? 'User' }},</p>
<p>Thank you for registering for the following events:</p>
<ul>
    @foreach ($events as $event)
        <li>{{ $event->name ?? 'Event' }} ({{ $event->start_time ?? 'N/A' }} - {{ $event->end_time ?? 'N/A' }})</li>
    @endforeach
</ul>
<p>We look forward to seeing you at the events.</p>
<p>If you wish to cancel your registration, please click the link below:</p>
<p>
    <a href="{{ $cancellationLink }}">
        Cancel Registration
    </a>
</p>
</body>
</html>
