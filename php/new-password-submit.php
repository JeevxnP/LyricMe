 <?php
/* Submit new password */
	//connect to database//
	include_once 'functions/dbFunctions.php'; 	//Enter details in config.inc.php first
	// Variables
	$userID = "";
	$tokenEmail = "";
	$password_1 = $_POST['password_1'];
	$password_2 = $_POST['password_2'];
	$selector = $_SESSION['selector'];
	$validator = $_SESSION['validator'];
	// change this to your corresponding path for demo
	$url = "http://localhost/lyric-me/php/token-selector-verified.php?selector=" . $selector . "&validator=" . $validator;
	// change this to your corresponding path for demo
	$index ="http://localhost/lyric-me/php";


	// token and validator check
	$currentDate = date("U");
	$res = select_tbPwdReset($selector, $currentDate);
	if (!$res) {
		echo '
			<script type="text/javascript">
			alert("This request has expired! You need to re-submit your reset request.");
			window.location.href = "resetpwd.php";
			</script>
			';
	}
	else{
		$tokenBin = hex2bin($validator);
		$tokenCheck = password_verify($tokenBin, $res['resetToken']);

		if (!$tokenCheck) {
			echo '
				<script type="text/javascript">
				alert("Token authentication failed! You need to re-submit your reset request.");
				window.location.href = "resetpwd.php";
				</script>
				';
		}
		else if ($tokenCheck) {
			$tokenEmail = $res['resetEmail'];
			$user = select_tbUser_email($tokenEmail);
			$row = $user->fetch_assoc();
			$userID = $row['account_name'];
			if (!$userID) {
				echo '
					<script type="text/javascript">
					alert("Error: Account not found! Try to re-submit your reset request or contact an admin.");
					window.location.href = "resetpwd.php";
					</script>
					';
			}
		}
	}

	// Validate password strength
	// Password should be at least 8 characters in length and should include at least one upper case letter, one number, and one special character.
	$uppercase = preg_match('@[A-Z]@', $password_1);
	$lowercase = preg_match('@[a-z]@', $password_1);
	$number    = preg_match('@[0-9]@', $password_1);
	$specialChars = preg_match('@[^\w]@', $password_1);
	if (!$uppercase || !$lowercase || !$number || !$specialChars || strlen($password_1) < 8) {
		echo "<script type='text/javascript'>alert('Password should be at least 8 characters in length and should include at least one upper case letter, one number, and one special character.');
			window.location.replace('" . $url . "');</script>";
	}
	// If password strong enough then check if they match
	else if ($password_1 != $password_2) {
		echo "<script type='text/javascript'>alert('Passwords do not match.');
			window.location.replace('" . $url . "');</script>";
	}
	else {
		$hashed_password = password_hash($password_1, PASSWORD_ARGON2I);
		update_password($userID, $hashed_password);
		delete_tbPwdReset_record($tokenEmail);

		echo "<script type='text/javascript'>alert('Your password has been updated.');
		window.location.replace('" . $index . "');</script>";
	}
?>