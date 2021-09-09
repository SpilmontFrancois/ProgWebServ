<?php

require 'users.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST')
    header('Location: signin.php');

if (isset($_POST['login']) && isset($_POST['password'])) {
    $login = htmlentities($_POST['login']);
    $password = htmlentities($_POST['password']);
    session_start();

    $found = false;
    foreach ($users as $log => $pass) {
        if ($login === $log && $password === $pass) {
            $found = true;
            $_SESSION['username'] = $login;
            header('Location: welcome.php');
        }
    }
    if (!$found) {
        $_SESSION['message'] = 'Nom d\'utilisateur ou mot de passe incorrect(s)';
        header('Location: signin.php');
    }
}

exit;
