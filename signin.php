<?php
session_start();
$message = isset($_SESSION['message']) && $_SESSION['message'] !== '' ? $_SESSION['message'] : '';

if ($_SERVER['REQUEST_METHOD'] === 'GET')
echo "<!DOCTYPE html>
<html>

<head>
	<meta charset='utf-8'>
	<title>Signin</title>
</head>

<body>
	<h1>Signin</h1>
	<div class='message'>$message</div>
	<br />
	<form action='authenticate.php' method='post'>
		<input name='login' type='text' placeholder='Login' />
		<input name='password' type='password' placeholder='Password' />
		<br />
		<br />
		<input type='submit' value='Connect me' />
	</form>
</body>

</html>"
?>