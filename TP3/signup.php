<?php
session_start();
$_SESSION['message'] = '';
$message = isset($_SESSION['message']) && $_SESSION['message'] !== '' ? $_SESSION['message'] : '';

if ($_SERVER['REQUEST_METHOD'] === 'GET')
echo "<!DOCTYPE html>
<html>

<head>
	<meta charset='utf-8'>
	<title>Sign up</title>
</head>

<body>
	<h1>Sign Up</h1>
	<div class='message'>$message</div>
	<br />
	<form action='adduser.php' method='post'>
		<input name='Rlogin' type='text' placeholder='Login' />
		<br />
		<br />
		<input name='Rpassword' type='password' placeholder='Password' />
		<br />
		<br />
		<input name='Rpassword2' type='password' placeholder='Confirm password' />
		<br />
		<br />
		<input type='submit' value='Register me' />
        <br />
		<br />
		<a href='signin.php'>Sign in</a>
	</form>
</body>

</html>"
?>