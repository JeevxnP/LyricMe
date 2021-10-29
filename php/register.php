<?php
/* Login: SELECT user input FROM dbUser to check if details correct*/

//connect to database//
include_once 'functions/dbFunctions.php'; 	//Enter details in config.inc.php first

// Variables
$username = $_POST['username'];
$full_name = $_POST['full_name'];
$email = $_POST['email'];
$password_1 = $_POST['password_1'];
$password_2 = $_POST['password_2'];
$authenticated = true;

// + check if 3 < length > 15
if ((strlen($username) > 15) || (strlen($username) < 3)) {
	$authenticated = false;
	echo "
		<style>
			#registration-box .form .item[data-error-username-length] input{
			    border-color: #c93432;
			    color: #c93432;
			    background: #fffafa;
			}

			#registration-box .form .item[data-error-username-length]::after{
			    content: attr(data-error-username-length);
			    color: #c93432;
			    font-size: 0.85em;
			    display: block;
			    margin: 10px 0;
			}
		</style>
	";
}
// check if username already taken
$user = select_tbUser($username)->fetch_assoc();
if ($user != 0) {
	$authenticated = false;
	echo "
		<style>
			#registration-box .form .item[data-error-username-taken] input{
			    border-color: #c93432;
			    color: #c93432;
			    background: #fffafa;
			}

			#registration-box .form .item[data-error-username-taken]::after{
			    content: attr(data-error-username-taken);
			    color: #c93432;
			    font-size: 0.85em;
			    display: block;
			    margin: 10px 0;
			}
		</style>
	";
}
if (empty($full_name) || strlen($full_name) > 100) {
	$authenticated = false;
	echo "
		<style>
			#registration-box .form .item[data-error-fullname] input{
			    border-color: #c93432;
			    color: #c93432;
			    background: #fffafa;
			}

			#registration-box .form .item[data-error-fullname]::after{
			    content: attr(data-error-fullname);
			    color: #c93432;
			    font-size: 0.85em;
			    display: block;
			    margin: 10px 0;
			}
		</style>
	";
}
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
	$authenticated = false;
	echo "
		<style>
			#registration-box .form .item[data-error-email-format] input{
			    border-color: #c93432;
			    color: #c93432;
			    background: #fffafa;
			}

			#registration-box .form .item[data-error-email-format]::after{
			    content: attr(data-error-email-format);
			    color: #c93432;
			    font-size: 0.85em;
			    display: block;
			    margin: 10px 0;
			}
		</style>
	";
}
$email_used = select_tbUser_email($email)->fetch_assoc();

if ($email_used != 0) {
	$authenticated = false;
	echo "
		<style>
			#registration-box .form .item[data-error-email-taken] input{
			    border-color: #c93432;
			    color: #c93432;
			    background: #fffafa;
			}

			#registration-box .form .item[data-error-email-taken]::after{
			    content: attr(data-error-email-taken);
			    color: #c93432;
			    font-size: 0.85em;
			    display: block;
			    margin: 10px 0;
			}
		</style>
	";
}

// Validate password strength
// Password should be at least 8 characters in length and should include at least one upper case letter, one number, and one special character.
$uppercase = preg_match('@[A-Z]@', $password_1);
$lowercase = preg_match('@[a-z]@', $password_1);
$number    = preg_match('@[0-9]@', $password_1);
$specialChars = preg_match('@[^\w]@', $password_1);
if (!$uppercase || !$lowercase || !$number || !$specialChars || strlen($password_1) < 8) {
	$authenticated = false;
	echo "
		<style>
			#registration-box .form .item[data-error-password-weak] input{
			    border-color: #c93432;
			    color: #c93432;
			    background: #fffafa;
			}

			#registration-box .form .item[data-error-password-weak]::after{
			    content: attr(data-error-password-weak);
			    color: #c93432;
			    font-size: 0.85em;
			    display: block;
			    margin: 10px 0;
			}
		</style>
	";
}
// If password strong enough then check if they match
elseif ($password_1 != $password_2) {
	$authenticated = false;
	echo "
		<style>
			#registration-box .form .item[data-error-password-match] input{
			    border-color: #c93432;
			    color: #c93432;
			    background: #fffafa;
			}

			#registration-box .form .item[data-error-password-match]::after{
			    content: attr(data-error-password-match);
			    color: #c93432;
			    font-size: 0.85em;
			    display: block;
			    margin: 10px 0;
			}
		</style>
	";
}
$authenticated = true;
if ($authenticated) {
	$hashed_password = password_hash($password_1, PASSWORD_ARGON2I);
	insert_tbUser($username, $full_name, $email, $hashed_password, "User", 0);
}
?>