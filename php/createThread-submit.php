<?php
/* createThread-submit: Check if file is valid and title name already exists before inserting into db*/

//connect to database//
include_once 'functions/dbFunctions.php'; 	//Enter details in config.inc.php first
	
	$title = $_POST['title'];
	$des = $_POST['description'];
	$validDes = false;
	$validFile = false;
	$validTitle = false;
	
	// Check if Title empty
	if ((strlen($title)) > 0) {
		$res = getThread_title($title);

		$exists = false;
		// Check if title already exists
		while ($row = $res->fetch_assoc()) {
		 	$exists = true;
		 	break;
		}
		if ($exists == false) {
			$validTitle = true;
		}
		else {
			echo "
				<style>
					.createThreadWrapper .form .item[data-error-title-exists] input{
						border-color: #c93432;
						color: #c93432;
						background: #fffafa;
					}

					.createThreadWrapper .form .item[data-error-title-exists]::after{
						content: attr(data-error-title-exists);
					    color: #c93432;
					    font-size: 0.85em;
					    display: block;
					    margin: 10px 0;
					}
				</style>
			";
		}



	}
	else {
		echo "
			<style>
				.createThreadWrapper .form .item[data-error-title-empty] input{
					border-color: #c93432;
					color: #c93432;
					background: #fffafa;
				}

				.createThreadWrapper .form .item[data-error-title-empty]::after{
					content: attr(data-error-title-empty);
				    color: #c93432;
				    font-size: 0.85em;
				    display: block;
				    margin: 10px 0;
				}
			</style>
		";
	}

	// Check if description is empty
	if (strlen($des) > 0) {
		$validDes = true;
	}
	else {
		echo "
			<style>
				.createThreadWrapper .form .item[data-error-des-empty] textarea{
					border-color: #c93432;
					color: #c93432;
					background: #fffafa;
				}

				.createThreadWrapper .form .item[data-error-des-empty]::after{
					content: attr(data-error-des-empty);
				    color: #c93432;
				    font-size: 0.85em;
				    display: block;
				    margin: 10px 0;
				}
			</style>
		";
	}


	if ($_FILES["file"]["name"] != "") {

		// max upload size 10mb
		// need size limit in php.ini
		$fileSize = $_FILES["file"]["size"];
		$maxSize = 10485760;

		// all audio files format has "audio/" in MIME TYPE
		$fileLoc = $_FILES["file"]["tmp_name"];
		$mimeType = mime_content_type($fileLoc);
		$mimeVal = explode("/", $mimeType)[0];

		// file type and size check
		if (($fileSize <= $maxSize) && ($mimeVal == "audio")) {
			$validFile = true;
		}
		else if ($fileSize > $maxSize) {
			echo "
				<style>
					.createThreadWrapper .upload[data-error-file-size] input{
						border-color: #c93432;
						color: #c93432;
						background: #fffafa;
					}

					.createThreadWrapper .upload[data-error-file-size]::after{
						content: attr(data-error-file-size);
					    color: #c93432;
					    font-size: 0.85em;
					    display: block;
					    margin: 10px 0;
					}
				</style>
			";
		}
		else if ($mimeVal != "audio") {
			echo "
				<style>
					.createThreadWrapper .upload[data-error-file-type] input{
						border-color: #c93432;
						color: #c93432;
						background: #fffafa;
					}

					.createThreadWrapper .upload[data-error-file-type]::after{
						content: attr(data-error-file-type);
					    color: #c93432;
					    font-size: 0.85em;
					    display: block;
					    margin: 10px 0;
					}
				</style>
			";
		}
	}
	else {
		echo "
			<style>
				.createThreadWrapper .upload[data-error-file-empty] input{
					border-color: #c93432;
					color: #c93432;
					background: #fffafa;
				}

				.createThreadWrapper .upload[data-error-file-empty]::after{
					content: attr(data-error-file-empty);
				    color: #c93432;
				    font-size: 0.85em;
				    display: block;
				    margin: 10px 0;
				}
			</style>
		";
	}


	// change folder permission to read write exexcute if not already
	$mod = substr(decoct(fileperms("../audio")), -3);
	if ($mod != 777) {
		echo "In order for php to write and execute files in /audio, folder permission needs to be changed to read write execute.";
		echo "<br>Execute in bash: chmod 777 audio/";
	}
	// Insert into database
	else if ($validDes && $validFile && $validTitle) {
		$countAr = getThreadCount()->fetch_assoc();
		$newID = reset($countAr) + 1;

		$fileName = $_FILES["file"]["name"];
		$ext = pathinfo($fileName, PATHINFO_EXTENSION);
		
		$path = "../audio/" . $newID . "." . $ext;


		// saving the file in the audio directory
		move_uploaded_file($_FILES["file"]["tmp_name"], $path);
		insert_tbThread($title, $des, $path, $_SESSION['username']);
		header("Location: index.php");
		exit();
	}

?>