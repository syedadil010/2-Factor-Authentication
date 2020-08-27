# 2-Factor-Authentication-using-Email
 ## Version 1
2FA is an extra layer of security used to make sure that people trying to gain access to an online account are who they say they are.  
First, a user will enter their username and a password. Then, instead of immediately gaining access, they will be required to provide another piece of information, which in our case is a One Time Password that you receive on yuor registered E-mail everytime you Log-in.

## Coming Soon
Google Authenticator, Twilio SMS verification.
## Libraries/ APIs:

### PHPMailer
PHPMailer is a code library to send emails safely and easily via PHP code from a web server.

### PHPGangsta
PHPMailer is a code library to send emails safely and easily via PHP code from a web server.

## Set-Up

Download the folder and if you have composer, run

```sh
composer require phpmailer/phpmailer
```
To use Google Aunthenticator, Download the file googleauthenticator.php from :   
  
 https://github.com/PHPGangsta/GoogleAuthenticator   

## Setting Up:
A simple example how to set up the Email details in mail_function.php 

```php
<?php	
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Message from index.php OTP and the $email to which $otp is sent
	function sendOTP($email,$otp) {
		
        require 'location of autoload file generated by composer';
	
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
