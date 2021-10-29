<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Log in or Sign up</title>
        <link rel="stylesheet" type="text/css" media="screen" href="../css/login-index.css">
        <link rel="stylesheet" type="text/css" media="screen" href="../css/menubar.css">
    </head>
    <?php
        session_start();
        if ($_SERVER['REQUEST_METHOD'] == 'POST')
        {
            /*Logging in*/
            if (isset($_POST['login'])){
                require 'login.php';
            }
        }
    ?>
    <body>
        <?php
            require_once('menubar.php');
        ?>
        <div id="login-box">
            <h1>Login</h1>

            <form action="login-index.php" method="post" autocomplete="off">

                <div class="form">
                    <div class="item" data-error="Details incorrect, try again!">
                       <h3>Username:</h3>
                       <input type="text" class="input" placeholder="Username" name="username" >
                    </div>
                    <div class="item" data-error="">
                        <h3>Password:</h3>
                        <input type="password" class="input" placeholder="Password" name="password">
                     </div>

                     <script type="text/javascript">
                        // Select all login-box .form .item that has the [data-error] attribute
                        // And for each of the input element (intEl), if there is 'input' (typed into input), remove the 'data-error' attribute from its parent element <div class...>
                         document.querySelectorAll('#login-box .form .item[data-error] input').forEach(inpEl => {inpEl.addEventListener('input', () => inpEl.parentElement.removeAttribute('data-error'));});
                     </script>
                </div>
                <div id = "login-button">
                    <button class="button button-block" name="login">Login</button>
                </div>
            </form>

            <div id="register-reset">
                <a href="registration.php" class="button">Register</a>
                <a href="resetpwd.php" class="button">Forgot Password</a>
            </div>
        </div>

    </body>
</html>