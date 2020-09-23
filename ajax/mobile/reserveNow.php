<?php
header("Access-Control-Allow-Origin: *");

require_once '../../core/config.php';
require 'PHPMailer-master/PHPMailerAutoload.php';

if(isset($_POST['id'])){

	$id = $mysqli_connect->real_escape_string($_POST['id']);
    $ref_number = getRefNum($id,'H');
    $user_id = $mysqli_connect->real_escape_string($_POST['user_id']);

    $query = $mysqli_connect->query("UPDATE tbl_reservation SET status='P' WHERE reservation_id='$id' AND ref_number='$ref_number'");
    if($query){
        //$mysqli_connect->query("UPDATE tbl_reservation_details SET status='P' WHERE ref_number='$ref_number'");
        
        $fetchData = $mysqli_connect->query("SELECT * FROM tbl_reservation WHERE reservation_id='$id' AND ref_number='$ref_number'");
        $row = $fetchData->fetch_array();
        $hotel_id = $row['hotel_id'];
        
        $sumTotal = $mysqli_connect->query("SELECT sum(amount) FROM tbl_reservation_details WHERE ref_number='$ref_number'");
        $total = $sumTotal->fetch_array();
        
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
        $bodyContent .= '<div style="border: 1px solid #E0E0E0;background: #fff;padding: 70px;"><center><h1>Your reservation is submitted!</center></h1><br><h2>You’re going to  <b>'.getHotel($hotel_id).'</b>!</h2><h2>Kindly wait for the confirmation of the '.getHotel($hotel_id).'</h2>';
        $bodyContent .= '<table style="width:100%"><tr><td>Check-in:</td><td>'.date('F d, Y',strtotime( $row["start_date"])).'</td></tr><tr><td>Check-out:</td><td>'.date('F d, Y',strtotime( $row["end_date"])).'</td></tr><tr><td>Total:</td><td>&#8369;'.number_format($total[0],2).'</td></tr></table>';
        $bodyContent .= '<center><h5 style="color: #9E9E9E;">Note on account security: Kwarto-app will never ask for your password and verification code via email, text or call. Only log in to the Kwarto-app mobile app.</h5></center></div></div>';
        
        $mail->Subject = "Reservation placed for ".getHotel($hotel_id)." (".$row['ref_number'].")";
        $mail->Body    = $bodyContent;
        
        if(!$mail->send()){
            echo 'Message could not be sent.';
            echo 'Mailer Error: ' . $mail->ErrorInfo;
        }else{
            if($query){
                echo 1;
            }else{
                echo 0;
             }
        }

    }else{
        echo 0;
    }
}

?>