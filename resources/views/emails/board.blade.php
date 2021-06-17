<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Email</title>
</head>
<body>
    (One Time Login Credentials) <br>
    Email : {{ $email }} <br>
    Password : {{ $password }} <br>
    Your email will expire on {{ $expiry_date }}
    Please Visit: <a target="_blank" href="https://app.hireworks.ai/temp-login">app.hireworks.ai/temp-login</a>
</body>
</html>