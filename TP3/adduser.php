<?php

require 'bdd.php';

session_start();
$_SESSION['message'] = '';

if ($_SERVER['REQUEST_METHOD'] !== 'POST')
    header('Location: signup.php');

$db = new PDO("mysql:host=localhost;dbname=" . DB_NAME, DB_USER, DB_PASS);

if (isset($_POST['Rlogin']) && isset($_POST['Rpassword']) && isset($_POST['Rpassword2'])) {
    if ($_POST['Rpassword'] === $_POST['Rpassword2']) {
        $login = htmlentities($_POST['Rlogin']);
        $password = password_hash(htmlentities($_POST['Rpassword']), PASSWORD_BCRYPT);
    } else {
        $_SESSION['message'] = 'Mots de passe différents';
        header('Location: signup.php');
    }

    try {
        $stmt = $db->prepare('select login from users where login = ?');
        $stmt->execute([$login]);
        foreach ($stmt as $row) {
            $user = $row;
        }

        if ($user)
            throw new Exception('User already exists');

        $stmt = $db->prepare('insert into users (login, password) values (?,?);');
        $stmt->execute([$login, $password]);
        $_SESSION['message'] = '';
        header('Location: signin.php');
    } catch (Exception $e) {
        $_SESSION['message'] = 'Un problème est survenu lors de la création de l\'utilisateur';
        header('Location: signup.php');
    }
}

exit;
