<?php
/* Registration page with one form and button to insert input to dbUser, the other one to return to login-index.php*/
session_start();
?>
<!DOCTYPE html>
<html lang="en">
	<head>
	    <meta charset="UTF-8">
	    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	    <title>Registration Page</title>
	    <link rel="stylesheet" href="../css/registration.css">
	    <link rel="stylesheet" href="../css/menubar.css">
	</head>
	<?php
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			/*Register*/
			if (isset($_POST['submit'])) {
				require 'register.php';
			}
		}
	?>	
<body>
	<?php
        require_once('menubar.php');
    ?>
    <div id="registration-box">
        <h1>Sign Up For Free</h1>
        <form action="registration.php" method="post" autocomplete="off">
	        <div class="form">
	            <div class="item" data-error-username-taken="Try again! Username already taken." data-error-username-length="Try again! Username must be 3-15 characters long.">
	               <h3>Username:</h3>
	               <input type="text" placeholder="Username" name="username" >
	            </div>
	            <div class="item" data-error-fullname="Try again! Full name must be 1-100 characters long.">
	                <h3>Full Name:</h3>
	                <input type="text" placeholder="Your Name" name="full_name">
	            </div>
	            <div class="item" data-error-email-format="Try again! Invalid email" data-error-email-taken="Try again! Email already used">
	                <h3>Email Address:</h3>
	                <input type="text" placeholder="xxxx@xxx.com" name="email" >
	             </div>
	            <div class="item" data-error-password-weak="Password should be at least 8 characters in length and should include at least one upper and lower case letter, one number, and one special character.">
	                <h3>Set Your Password:</h3>
	                <input type="password" placeholder="Password" name="password_1">
	            </div>
	            <div class="item" data-error-password-match="Try again! Passwords don't match.">
	                <h3>Confirm Your Password:</h3>
	                <input type="password" placeholder="Password" name="password_2">
	            </div>
                 <script type="text/javascript">
	                // Select all login-box .form .item that has the [data-error-...] attribute
	                // And for each of the input element (intEl), if there is 'input' (typed into input), remove the 'data-error-...' attribute from its parent element <div class...>
	                	//username
	                 document.querySelectorAll('#registration-box .form .item[data-error-username-taken] input').forEach(inpEl => {inpEl.addEventListener('input', () => inpEl.parentElement.removeAttribute('data-error-username-taken'));});
	                 document.querySelectorAll('#registration-box .form .item[data-error-username-length] input').forEach(inpEl => {inpEl.addEventListener('input', () => inpEl.parentElement.removeAttribute('data-error-username-length'));});
	                 	//Full name
	                 document.querySelectorAll('#registration-box .form .item[data-error-fullname] input').forEach(inpEl => {inpEl.addEventListener('input', () => inpEl.parentElement.removeAttribute('data-error-fullname'));});
	                 	//email
	                 document.querySelectorAll('#registration-box .form .item[data-error-email-format] input').forEach(inpEl => {inpEl.addEventListener('input', () => inpEl.parentElement.removeAttribute('data-error-email-format'));});
	                 document.querySelectorAll('#registration-box .form .item[data-error-email-taken] input').forEach(inpEl => {inpEl.addEventListener('input', () => inpEl.parentElement.removeAttribute('data-error-email-taken'));});
	                 	//password
	                 document.querySelectorAll('#registration-box .form .item[data-error-password-weak] input').forEach(inpEl => {inpEl.addEventListener('input', () => inpEl.parentElement.removeAttribute('data-error-password-weak'));});
	                 document.querySelectorAll('#registration-box .form .item[data-error-password-match] input').forEach(inpEl => {inpEl.addEventListener('input', () => inpEl.parentElement.removeAttribute('data-error-password-match'));});
                 </script>
	        </div>
		    <button class="button button-block" name="submit">Sign Up</button>
		</form>
			<a href="login-index.php" class="button">Back to Login</a>
    </div>

    
</body>
</html>
