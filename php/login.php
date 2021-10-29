<?php
/* Login: SELECT user input FROM dbUser to check if details correct*/

//connect to database//
include_once 'functions/dbFunctions.php'; 	//Enter details in config.inc.php first

// Vairables
$username = $_POST['username'];
$password = $_POST['password'];
$results = select_tbUser($username);

// No data fetched, user doesn't exist
$user = $results->fetch_assoc();
if ($user != 0) {
	// check if password correct
	if (password_verify($password, $user['password'])) {
		$_SESSION['username'] = $user['account_name'];
		$_SESSION['full_name'] = $user['full_name'];
		$_SESSION['email'] = $user['email'];
		$_SESSION['account_type'] = $user['account_type'];
		$_SESSION['points'] = $user['points'];
		$_SESSION['created_at'] = $user['created_at'];

		// in thread.php/profile.php, if logged_in is true then can fetch personal details 
		$_SESSION['logged_in'] = true;
		// direct to index.php
		header("Location: index.php");
		exit;
	}
}
else{
	// insert CSS statement to display error message
	echo "
		<style>
			#login-box .form .item[data-error] input{
		    border-color: #c93432;
		    color: #c93432;
		    /*Change to a background color you think is good*/
		    background: #fffafa;
			}

		#login-box .form .item[data-error]::after{
		    content: attr(data-error);
		    /*Pick a color easier to read*/
		    color: #c93432;
		    font-size: 0.85em;
		    display: block;
		    margin: 10px 0;
			}
		</style>
		";
}

?>