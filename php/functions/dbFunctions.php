<?php
	// Connection parameters
	require_once('config.inc.php');
	$testMsgs = false; // true = on, false = off

	// Connection to $database
	$conn = new mysqli($database_host, $database_user, $database_pass, $database_name);

	// Check connection
	checkConnection($conn);		//only for development purposes, comment out if otherwise

	//Enumerate contents of database into tables
	// showTables();		//only for development purposes, comment out if otherwise

function checkConnection($conn)
{
	if ($conn -> connect_error)
	{
		die('Connect Error ('.$mysqli -> connect_errno.') '.$mysqli -> connect_error);
	}
	// echo "Connected successfully<br/><br/>";
}

function doSQL($conn, $sql, $testMsgs)
{
	if ($testMsgs)
	{
		echo ("<br><code>SQL: $sql</code>");
		if ($result = mysqli_query($conn, $sql, true))
			echo ("<code> - OK</code></br>");
		else
			echo ("<code> - FAIL! " . $conn->error . " </code>");
	}
	else
		$result = mysqli_query($conn, $sql, false);
	return $result;
}

// User info related block
//
function insert_tbUser($account_name, $full_name, $email, $password, $account_type, $points)
{
	global $conn;
	global $testMsgs;
	//escape input to prevent sql_injections//
	$account_name = mysqli_escape_string($conn, $account_name);
	$full_name = mysqli_escape_string($conn, $full_name);
	$sql = "INSERT INTO tbUser (account_name, full_name, email, password, account_type, points, created_at)
			VALUES ('" . $account_name ."', '" . $full_name ."', '" . $email ."', '" . $password . "', '" . $account_type ."', '" . $points ."', '" . date("Y-m-d H:i:s") . "') ";
	doSQL($conn, $sql, $testMsgs);
}

function select_tbUser($account_name)
{
	global $conn;
	global $testMsgs;
	//escape input to prevent sql_injections//
	$safe_user_name = mysqli_escape_string($conn, $account_name);
	$sql = "SELECT * FROM tbUser WHERE account_name = '" . $account_name . "'";
	$results = doSQL($conn, $sql, $testMsgs);
	return $results;
/*	while ($row = $results->fetch_assoc()) {
	echo ($row['account_name'] . $row['full_name'] . $row['email'] . $row['password'] . $row['account_type'] . $row['points'] . $row['created_at']);
	}*/
}

function select_tbUser_email($email)
{
	global $conn;
	global $testMsgs;
	//escape input to prevent sql_injections//
	$safe_email = mysqli_escape_string($conn, $email);
	$sql = "SELECT * FROM tbUser WHERE email = '" . $safe_email . "'";
	$results = doSQL($conn, $sql, $testMsgs);
	return $results;
}

function update_tbUser($account_name, $full_name, $email, $password, $account_type, $points)
{
	global $conn;
	global $testMsgs;
	$sql = "UPDATE tbUser 
			SET full_name = '" . $full_name . "', email = '" . $email . "', password = '" . $password . "', account_type = '" . $account_type . "', points = '" . $points . "' WHERE account_name = '" . $account_name . "'";
	doSQL($conn, $sql, $testMsgs);
}

function update_password($account_name, $password)
{
	global $conn;
	global $testMsgs;
	$sql = "UPDATE tbUser
			SET password ='" . $password . "' WHERE account_name = '" . $account_name . "'";
	doSQL($conn, $sql, $testMsgs);
}

function userPointsPlusOne($account_name)
{
	global $conn;
	global $testMsgs;
	$sql = "SELECT points FROM tbUser WHERE account_name ='" . $account_name . "'";
	$current_points = doSQL($conn, $sql, $testMsgs)->fetch_array()[0];
	$new_points = intval($current_points) + 1;
	$sql = "UPDATE tbUser SET points = '" . $new_points . "' WHERE account_name = '" . $account_name . "'";
	doSQL($conn, $sql, $testMsgs);
}

function suspendUser($account_name, $reason)
{
	global $conn;
	global $testMsgs;
	$sql = "UPDATE tbUser SET suspended ='1', suspension_reason ='" . $reason . "' WHERE account_name ='" . $account_name . "'";
	doSQL($conn, $sql, $testMsgs);
}

function unsuspendUser($account_name)
{
	global $conn;
	global $testMsgs;
	$sql = "UPDATE tbUser SET suspended ='0', suspension_reason=NULL WHERE account_name ='" . $account_name . "'";
	doSQL($conn, $sql, $testMsgs);
}

function delete_tbUser($account_name)
{
	global $conn;
	global $testMsgs;

	$sql = "DELETE FROM tbUser WHERE account_name = '" . $account_name . "'";
	doSQL($conn, $sql, $testMsgs);
}

function delete_resetToken($email)
{
	global $conn;
	global $testMsgs;

	$safe_email = mysqli_escape_string($conn, $email);

	$sql = "DELETE FROM tbPwdReset WHERE resetEmail = '" . $safe_email . "'";
	doSQL($conn, $sql, $testMsgs);
}

function insert_tbPwdReset($email, $selector, $token, $expires)
{
	global $conn;
	global $testMsgs;

	$safe_email = mysqli_escape_string($conn, $email);
	$hashed_token = password_hash($token, PASSWORD_DEFAULT);

	$sql = "INSERT INTO tbPwdReset (resetEmail, resetSelector, resetToken, resetExpires) VALUES ('" . $safe_email . "', '" . $selector . "', '" . $hashed_token . "' ,'" . $expires . "')";
	doSQL($conn, $sql, $testMsgs);
}

function select_tbPwdReset($selector, $currentDate)
{
	global $conn;
	global $testMsgs;

	$sql = "SELECT * FROM tbPwdReset WHERE resetSelector ='" .$selector . "' AND resetExpires >= '" . $currentDate . "'";
	$result = doSQL($conn, $sql, $testMsgs);
	$row = $result->fetch_assoc();
	return $row;
}

function delete_tbPwdReset_record($email)
{
	global $conn;
	global $testMsgs;

	$sql = "DELETE FROM tbPwdReset WHERE resetEmail = '" .$email . "'";
	doSQL($conn, $sql, $testMsgs);
}

function findUserThreads($account_name)
{

}

function findUserComments($account_name)
{

}

function findUserLikes($account_type, $type)	// type = thread or comment
{

}
//
// End of User info related block



// Thread related block
//
function insert_tbThread($title, $des, $path, $author)
{
	global $conn;
	global $testMsgs;
	$sql = "INSERT INTO tbThread (title, description, recording_path, created_at, author)
			VALUES ('" . $title . "', '" . $des . "', '" . $path . "', '" . date("Y-m-d H:i:s") . "', '" . $author . "')";
	doSQL($conn, $sql, $testMsgs);
}

function update_tbThread($id, $des, $path) 		//only description and path can be changed
{
	global $conn;
	global $testMsgs;
	$sql = "UPDATE tbThread 
			SET description ='" . $des . "', recording_path ='" . $path . "'" .
			"WHERE id ='" . $id . "'";
	doSQL($conn, $sql, $testMsgs);
}

function delete_tbThread($id)
{

}

function getThreads($order,$searchString)		//order by ASC or DSC, when sort symbol pressed, state of current order should be stored in variable and sent as parameter to here
{
	global $conn;
	global $testMsgs;

	// Empty search string finds all items from tbThread
	if ($searchString == "")
		$sql = "SELECT * FROM tbThread ORDER BY created_at " . $order;
	
	// Specified search string finds title/description/author which includes the specified phrase
	else
		$sql = "SELECT * FROM tbThread WHERE title LIKE '%" . $searchString . "%' OR description LIKE '%" . $searchString . "%' OR author LIKE '%" . $searchString . "%' ORDER BY created_at " . $order;
	
	$result = doSQL($conn, $sql, $testMsgs);
	return $result;
}

function getThread($id)
{
	global $conn;
	global $testMsgs;

	$sql = "SELECT * FROM tbThread WHERE id = '" . $id . "'";
	$result = doSQL($conn, $sql, $testMsgs);
	return $result;

}

function getFilePath($id)
{
	global $conn;
	global $testMsgs;

	$sql ="SELECT recording_path FROM tbThread WHERE id ='" . $id . "'";
	$result = doSQL($conn, $sql, $testMsgs);
	$resAr = $result -> fetch_assoc();
	return reset($resAr);
}
//
// End of thread related block

//Comment related block
//
function getThreadComments($id)
{
	global $conn;
	global $testMsgs;
	
	$sql = "SELECT * FROM tbComment WHERE thread = '" . $id . "'";
	$result = doSQL($conn, $sql, $testMsgs);
	return $result;

}

function addNewComment($comment,$time,$creator,$threadID)
{
	global $conn;
	global $testMsgs;

	$sql = "INSERT INTO tbComment (text, created_at, author, thread) 
                    VALUES ('" . $comment . "','" . $time . "','" . $creator . "','" . $threadID . "')";
	$result = doSQL($conn, $sql, $testMsgs);
}

function updateCorrectComment($id,$mark)
{
	global $conn;
	global $testMsgs;

	$sql = "UPDATE tbComment SET confirm=$mark WHERE id=$id";
	$result = doSQL($conn, $sql, $testMsgs);
}
//
//End of comment related block

//Create thread block
//
function getThread_title($title)
{
	global $conn;
	global $testMsgs;

	$sql = "SELECT * FROM tbThread WHERE title = '" . $title . "'";
	$result = doSQL($conn, $sql, $testMsgs);
	return $result;
}

function getThreadCount()
{
	global $conn;
	global $testMsgs;

	$sql = "SELECT COUNT(*) FROM tbThread";
	$result = doSQL($conn, $sql, $testMsgs);
	return $result;
}
//
//End of create thread block

?>