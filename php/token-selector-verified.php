<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Reset Password</title>
        <link rel="stylesheet" href="../css/new-password.css">
        <link rel="stylesheet" href="../css/menubar.css">
    </head>
    <?php
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
            $_SESSION['selector'] = $_GET["selector"];
            $_SESSION['validator'] = $_GET["validator"];
           }
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
             if (isset($_POST['new-pwd-submit'])) {
                require 'new-password-submit.php';
             }
         } 
    ?>
<body>
    <?php
       require_once('menubar.php');
    ?>
    <div id="new-pwd-box">
        <h1>Reset your password here</h1>
        <form action="new-password.php" method="post" autocomplete="off">
            <div class="item">
                <h3>Set Your Password:</h3>
                <input type="password" placeholder="Password" name="password_1">
            </div>
            <div class="item">
                <h3>Confirm Your Password:</h3>
                <input type="password" placeholder="Password" name="password_2">
            </div>
            <button name="new-pwd-submit">Confirm password</button>
        </form>
        <a href="login-index.php" class="button">Back to Login</a>
    </div>
</body>
</html>