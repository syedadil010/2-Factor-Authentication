<?php	
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Message from index.php OTP and the email to which OTP is sent
	function sendOTP($email,$otp) {
		
        require 'C:\wamp64\www\2fa-email\vendor\autoload.php';
	
		$message_body = "Your verfication code is:<br/><br/>" . $otp;
		$mail = new PHPMailer();
		$mail->IsSMTP();
		$mail->SMTPDebug = 0;
		$mail->SMTPAuth = TRUE;
        $mail->SMTPSecure = 'tls'; // tls or ssl
        $mail->SMTPOptions = array(
            'ssl' => array(
                'verify_peer' => false,
                'verify_peer_name' => false,
                'allow_self_signed' => true
            )
        );
		$mail->Port     = 587;
		// Username and Password for sending Email Service
		$mail->Username = "your username/email";
		$mail->Password = "your password";
		$mail->Host     = "smtp.gmail.com";
		$mail->Mailer   = "smtp";
		$mail->SetFrom("sending email", "sender name");
		$mail->AddAddress($email);
		$mail->Subject = "OTP to Login";
		$mail->MsgHTML($message_body);
		$mail->IsHTML(true);		
		$result = $mail->Send();
		
		return $result;
	}
?>