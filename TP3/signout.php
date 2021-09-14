<?php
session_start();
unset($_SESSION['username']);
$_SESSION['message'] = '';
header('Location: signin.php');

exit;
