


<!DOCTYPE html>
<html>
<head>
    <title>Welcome Email</title>
</head>

<body>
<h2>Welcome to the Lux Express : {{$user['fullName']}}</h2>
<br/>
Your registered email is {{$user['email']}} , Please click on the below link to verify your email account
<br/>
<a href="{{route('verify.user', $user->verifyUser->token)}}">Verify Email</a>
</body>

</html>