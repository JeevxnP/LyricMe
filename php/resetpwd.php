<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Reset Password</title>
        <link rel="stylesheet" href="../css/resetpwd.css">
        <link rel="stylesheet" href="../css/menubar.css">
    </head>
    <?php
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
             if (isset($_POST['reset-request-submit'])) {
                 require 'reset-request.php';
             }
         } 
    ?>
<body>
    <?php
        require_once('menubar.php');
    ?>
    <div id="reset-box">
        <h1>Reset your password</h1>
        <p>A link to reset your password will be sent to your email.</p>
        <form action="resetpwd.php" method="post" autocomplete="off">
            <div class="item" data-error-email-format="Try again! Invalid email" reset-request-success="Reset request submitted! Check your e-mail">
               <input type="text" placeholder="Your email" name="email">
            </div>
            <script type="text/javascript">
                 document.querySelectorAll('#reset-box form .item[data-error-email-format] input').forEach(inpEl => {inpEl.addEventListener('input', () => inpEl.parentElement.removeAttribute('data-error-email-format'));});
                 document.querySelectorAll('#reset-box form .item[reset-request-success] input').forEach(inpEl => {inpEl.addEventListener('input', () => inpEl.parentElement.removeAttribute('reset-request-success'));});
             </script>
            <button name="reset-request-submit">Send the email</button>
        </form>
        <a href="login-index.php" class="button">Back to Login</a>
    </div>
</body>
</html>