<?php
session_start();
$message = isset($_SESSION['message']) && $_SESSION['message'] !== '' ? $_SESSION['message'] : '';

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_SESSION['username']))
echo "<!DOCTYPE html>
<html>

<head>
	<meta charset='utf-8'>
	<title>Change password</title>
</head>

<body>
	<h1>Change password</h1>
	<div class='message'>$message</div>
	<br />
	<form action='changepassword.php' method='post'>
		<input name='Mpassword' type='password' placeholder='New password' />
		<br />
		<br />
		<input name='Mpassword2' type='password' placeholder='Confirm password' />
		<br />
		<br />
		<input type='submit' value='Change !' />
        <br />
		<br />
        <a href='welcome.php'>Back to welcome page</a>
	</form>
</body>
</html>";
else
    header('Location: signin.php');
?>