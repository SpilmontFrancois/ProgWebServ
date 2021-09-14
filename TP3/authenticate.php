<?php

require 'bdd.php';

session_start();

if ($_SERVER['REQUEST_METHOD'] !== 'POST')
    header('Location: signin.php');

$db = new PDO("mysql:host=localhost;dbname=" . DB_NAME, DB_USER, DB_PASS);

if (isset($_POST['login']) && isset($_POST['password'])) {
    $login = htmlentities($_POST['login']);
    $password = htmlentities($_POST['password']);

    $stmt = $db->prepare('select login, password from users where login = ?');
    $stmt->execute([$login]);
    foreach ($stmt as $row) {
        $user = $row;
    }

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['username'] = $login;
        header('Location: welcome.php');
    } else {
        $_SESSION['message'] = 'Nom d\'utilisateur ou mot de passe incorrect(s)';
        header('Location: signin.php');
    }
}

exit;
