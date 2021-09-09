<?php

require 'bdd.php';
$db = new PDO("mysql:host=localhost;dbname=" . DB_NAME, DB_USER, DB_PASS);

if ($_SERVER['REQUEST_METHOD'] !== 'POST')
    header('Location: signin.php');

if (isset($_POST['login']) && isset($_POST['password'])) {
    $login = htmlentities($_POST['login']);
    $password = htmlentities($_POST['password']);
    session_start();
    $stmt = $db->prepare('select * from users where login = ? AND password = ?');
    $user = $stmt->execute([$login, $password]);
    // Problème à corriger : renvoie true à chaque fois
    print_r($user);

    if ($user) {
        $_SESSION['username'] = $login;
        //header('Location: welcome.php');
    } else {
        $_SESSION['message'] = 'Nom d\'utilisateur ou mot de passe incorrect(s)';
        header('Location: signin.php');
    }
}

exit;
