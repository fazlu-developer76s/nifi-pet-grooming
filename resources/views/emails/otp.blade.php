<!-- resources/views/emails/otp.blade.php -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your OTP Code</title>
</head>
<body>
    <h1>Your OTP Code</h1>
    <p>Your one-time password (OTP) is: <strong>{{ $otp }}</strong></p>
    <p>This code is valid for a limited time only. Please do not share it with anyone.</p>
</body>
</html>
