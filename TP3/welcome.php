<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] !== 'GET' || !isset($_SESSION['username']))
    header('Location: signin.php');

?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>My account</title>
</head>

<body>
    <p>
        Hello <?php echo $_SESSION['username'] ?> !<br />
        Welcome on your account.
    </p>
    <a href='formpassword.php'>Change password</a>
    <br />
    <a href='signout.php'>Disconnect</a>
    <br />
    <a href='deleteuser.php'>Delete user</a>
</body>

</html>