<?php
header("Access-Control-Allow-Origin: *");

require_once '../../core/config.php';
require 'PHPMailer-master/PHPMailerAutoload.php';

if(isset($_POST['user_id'])){

	$user_id = $mysqli_connect->real_escape_string($_POST['user_id']);
    $hotel_id = $mysqli_connect->real_escape_string($_POST['hotel_id']);

    $access_code = substr(str_shuffle("0123456789"), 0, 5);
    $fetchCustomer = $mysqli_connect->query("SELECT email FROM tbl_users WHERE user_id='$user_id'");
    $cust_email = $fetchCustomer->fetch_array();
    
	$mail = new PHPMailer;

	//$mail->isSMTP();                            // Set mailer to use SMTP
	$mail->Host = 'smtp.gmail.com';             // Specify main and backup SMTP servers
	$mail->SMTPAuth = true;                     // Enable SMTP authentication
	$mail->Username = 'kwartoappinfo@gmail.com';          // SMTP username
	$mail->Password = 'kwartoApp12345!'; // SMTP password
	$mail->SMTPSecure = 'tls';                  // Enable TLS encryption, `ssl` also accepted
	$mail->Port = 587;                          // TCP port to connect to
	
	$mail->setFrom('kwartoappinfo@gmail.com', 'Kwarto-app');
	$mail->addReplyTo('kwartoappinfo@gmail.com', 'Kwarto-app');

	$mail->addAddress($cust_email[0]);   // Add a recipient
	$mail->isHTML(true);  // Set email format to HTML
	
	$bodyContent = '<div style="padding:70px;"><div style="border: 1px solid #BDBDBD;background: #607D8B;padding: 12px;"><center><h1 style="color: #EEEEEE;">Kwarto-app</h1></center></div>';
	$bodyContent .= '<div style="border: 1px solid #E0E0E0;background: #fff;padding: 70px;"><center><h2>You are requesting to access <b>'.getHotel($hotel_id).'</b></h2><h3>Use this verification code to confirm this action:</h3></center>';
    $bodyContent .= "<center><h3><strong style='letter-spacing: 10px;'>".$access_code."</strong></h3></center>";
	$bodyContent .= '<center><h5 style="color: #9E9E9E;">Note on account security: Kwarto-app will never ask for your password and verification code via email, text or call. Only log in to the Kwarto-app mobile app.</h5></center></div></div>';
	
	$mail->Subject = getHotel($hotel_id).' ACCESS CODE';
	$mail->Body    = $bodyContent;
	
	$fetch = $mysqli_connect->query("SELECT * FROM tbl_access_logs WHERE user_id='$user_id' AND hotel_id='$hotel_id' AND status='P'");
    if(mysqli_num_rows($fetch) > 0){
        echo "ok";
    }else{
		$mysqli_connect->query("DELETE FROM tbl_access_logs WHERE user_id='$user_id' AND hotel_id='$hotel_id' AND status!='P'");
		
		if(!$mail->send()){
			echo 'Message could not be sent.';
			echo 'Mailer Error: ' . $mail->ErrorInfo;
		}else{
			$mysqli_connect->query("INSERT INTO tbl_access_logs SET code='$access_code',user_id='$user_id',hotel_id='$hotel_id'");
	
			echo $access_code;
		}
	}
	

}

?>