<?php
/* Logout set session variable 'logged_in' to false and redirects to main.php */
	session_start();
	$_SESSION['logged_in'] = false;
	header("refresh:0 url=index.php");
?>