<!DOCTYPE html>
<html>
<head>
    <title>Welcome to Provident Fund</title>
</head>
<body>
    <h1>Welcome, {{ $user->fname }} {{ $user->lname }}!</h1>
    <p>Your account has been created successfully.</p>
    
    <h2>Login Credentials:</h2>
    <ul>
        <li><strong>Email:</strong> {{ $user->email }}</li>
        {{-- convert password to raw text --}}
        <li><strong>Password:</strong> {{ $password }}</li>
        <li><strong>Staff No:</strong> {{ $user->staff_no }}</li>
    </ul>
    
    <p>Login at: <a href="{{ url('/') }}">Provident Fund Portal</a></p>
    
    <p>Best regards,<br>Provident Fund Admin</p>
</body>
</html>

