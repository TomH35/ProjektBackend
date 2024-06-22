<!DOCTYPE html>
<html>
<head>
    <title>Cancel Registration</title>
</head>
<body>
<h1>Cancel Registration</h1>
<form action="{{ url('api/cancel-registration') }}" method="POST">
    @csrf
    <input type="hidden" name="token" value="{{ $token }}">
    <p>Are you sure you want to cancel your registration for this event?</p>
    <button type="submit">Yes, cancel my registration</button>
</form>
</body>
</html>
