<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Email</title>
</head>
<body>
    Your Data Credentials<br>
    Email : {{ $email }} <br>
    Password : {{ $password }} <br>
    Please Visit: <a href="{{ env('APP_URL') }}">{{ env('APP_URL') }}</a>
</body>
</html>