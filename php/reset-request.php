<?php
	/* Reset: Send reset password email to entered address if format correct*/

	//connect to database//
	include_once 'functions/dbFunctions.php'; 	//Enter details in config.inc.php first

	// Variables
	$email = $_POST['email'];

	if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
		include_once 'functions/PhpMailer/PHPMailerAutoload.php';	//php mailer function
		$mail = new PHPMailer;

		$mail->IsSMTP();
		$mail->Host='smtp.gmail.com';
		$mail->Port=587;
		$mail->SMTPAuth = true;
		$mail->SMTPSecure='tls';

		$mail->Username='LyricMeY13@gmail.com';
		$mail->Password='lyricme@y13';

		$mail->setFrom('LyricMeY13@gmail.com', 'LyricMe');
		$recipient = $email;
		$mail->addAddress('harjeevan.panesar@student.manchester.ac.uk');	// change to personal email for demo

		$selector = bin2hex(random_bytes(8));
		$token = random_bytes(32);

		// change to own path for demo
		$url = "http://localhost/lyric-me/php/token-selector-verified.php?selector=" . $selector . "&validator=" . bin2hex($token);

		// U format = today's date in seconds since 1970
		// + 10minues
		$expires = date("U") + 600;
		delete_resetToken($email);
		insert_tbPwdReset($email, $selector, $token, $expires);

		$mail->isHTML(true);
		$mail->Subject = "Password reset request for LyricMe";
		$message = "<p>A request to reset your password has been submitted. Below is the link to reset your password. If you did not submit this request, please ignore this email</p>";
		$message .= "<p> Here is your password reset link: </br>";
		$message .= '<a href = "' . $url . '">' . $url . '</a></p>';
		$mail->Body=$message;
		// $headers = "From: LyricMe <LyricMe@gmail.com>\r\n";
		// $headers .= "Reply-To: LyricMe@gmail.com\r\n";
		// $headers .= "Content-type: text/html\r\n";

		if(!$mail->send()) {
			echo "
				<style>
					#reset-box form .item[data-error-email-format] 
					input{
				    border-color: #c93432;
				    color: #c93432;
				    /*Change to a background color you think is good*/
				    background: #fffafa;
					}

					#reset-box form .item[data-error-email-format]::after{
				    content: attr(data-error-email-format);
				    /*Pick a color easier to read*/
				    color: #c93432;
				    font-size: 0.85em;
				    display: block;
				    margin: 10px 0;
					}
				</style>
				";
		} 
		else {
			echo "
				<style>
					#reset-box form .item[reset-request-success] 
					input{
				    border-color: #66ff66;
				    color: #66ff66;
				    /*Change to a background color you think is good*/
				    background: #ccffcc;
					}

					#reset-box form .item[reset-request-success]::after{
				    content: attr(reset-request-success);
				    /*Pick a color easier to read*/
				    color: #66ff66;
				    font-size: 0.85em;
				    display: block;
				    margin: 10px 0;
					}
				</style>
				";
		}

	}
	else {
		// insert CSS statement to display error message
		echo "
			<style>
				#reset-box form .item[data-error-email-format] 
				input{
			    border-color: #c93432;
			    color: #c93432;
			    /*Change to a background color you think is good*/
			    background: #fffafa;
				}

				#reset-box form .item[data-error-email-format]::after{
			    content: attr(data-error-email-format);
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