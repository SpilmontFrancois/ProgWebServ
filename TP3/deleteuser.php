<?php

require 'bdd.php';

session_start();
$_SESSION['message'] = '';

if ($_SERVER['REQUEST_METHOD'] !== 'GET' && !isset($_SESSION['username']))
    header('Location: welcome.php');

$db = new PDO("mysql:host=localhost;dbname=" . DB_NAME, DB_USER, DB_PASS);

try {
    $stmt = $db->prepare('delete from users where login=?;');
    $stmt->execute([$_SESSION['username']]);
    session_destroy();
    header('Location: signin.php');
} catch (Exception $e) {
    header('Location: welcome.php');
}
exit;
