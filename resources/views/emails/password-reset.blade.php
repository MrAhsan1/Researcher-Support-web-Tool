<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
</head>

<body>
	<h1>Welcome to our mail System</h1>
	<h1>Reset Your password</h1>
	<br/>
	<?php $token = str_random(30);?>
	{{$token}}
	<a href="http://localhost/myproject/public/reset-password/{{$token}}">Clck here to reset Your password</a>
</body>

</html>