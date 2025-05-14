<!DOCTYPE html>
<html>
<head>
    <title>Welcome to Laravel CRM</title>
</head>
<body>
    <h1>Welcome, {{ $user->name }}!</h1>
    <p>Thank you for registering with Laravel CRM. Your account is now active.</p>
    <p>Login to start managing your customers, proposals, and invoices.</p>
    <a href="{{ url('/login') }}">Login Now</a>
</body>
</html>