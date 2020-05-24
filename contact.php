<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST' and $_POST['email']) {


if(isset($_POST['email']))
{
	require_once('class.phpmailer.php');
	require_once('class.smtp.php');			
	$name    = $_POST['name'];
	$email   = $_POST['email'];
	$phone   = $_POST['phone'];
	$message = $_POST['message'];
	$captcha = $_POST['token'];

	$secretKey = "6LfCXfsUAAAAAJwwgEMZ8_qb7igzhXkhcCTZx_JU";
    $ip 	   = $_SERVER['REMOTE_ADDR'];

	$url =  'https://www.google.com/recaptcha/api/siteverify?secret=' . urlencode($secretKey) .  '&response=' . urlencode($captcha);
    $response = file_get_contents($url);
    $responseKeys = json_decode($response,true);
    header('Content-type: application/json');

    if($responseKeys["success"]) {
				$sending_message = "
				Name : ".$name." <br>
				Email : ".$email." <br>
				Phone : ".$phone." <br>
				Message :".$message."
				";
				$mail             = new PHPMailer();

				$body             = $sending_message;
				
				$username = 'support@wiwoenterprises.in';
				$password = '7ZSiaps2Vxjjzw7';
				$to 	  = "naveen@faircodetech.com";
				
				$mail->IsSMTP(); // telling the class to use SMTP
				
				$mail->SMTPAuth   = true;                  // enable SMTP authentication
				$mail->SMTPSecure = "tls";                 // sets the prefix to the servier
				$mail->Host       = "smtp.gmail.com";      // sets GMAIL as the SMTP server
				$mail->Port       = 587;                   // set the SMTP port for the GMAIL server
				$mail->Username   = $username;  // GMAIL username
				$mail->Password   = $password;            // GMAIL password
				
				$mail->SetFrom($username, 'qwise.in - Contact ');

				// $mail->AddReplyTo($username,"Faircode technologies");	

				
				
				$mail->Subject    = "Qwise Contact";
				
				$mail->AltBody    = "To view the message, please use an HTML compatible email viewer!"; // optional, comment out and test
				

				$mail->MsgHTML($body);
				$address = $email;
				$mail->AddAddress($to, "Contact Page");
				
				if(!$mail->send()) {
			   		echo json_encode(array('status'=>'error','message'=>'Something went wrong! Please check your contact informations and try again'));
				} else {
				   echo json_encode(array('status'=>'success','message'=>'Thank you for contacting Faircode Technologies, we will contact you shortly'));
				}
		}else{
			echo json_encode(array('status'=>'error','message'=>'You are a spammer !'));
		}
	} 
 // …
}else{
	echo header('location:https://qwise.in');
}		
 ?>