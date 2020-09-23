<?php
require_once '../core/config.php';

if(isset($_POST['id'])){
    $id = $mysqli_connect->real_escape_string($_POST['id']);
   
    $fetchData = $mysqli_connect->query("SELECT * FROM tbl_reservation WHERE reservation_id='$id'");
    $row = $fetchData->fetch_array();
    $customer_id = $row['customer_id'];
    $hotel_id = $row['hotel_id'];
    
    
    $query = $mysqli_connect->query("UPDATE tbl_reservation SET status='C' WHERE reservation_id='$id'");
    if($query){
        echo 1;
        insertNotif($customer_id, "Booking status for Ref # ".$row['ref_number']." cancel", "warning",$hotel_id);
       
        insertLogs($_SESSION['user_id'], "Update Booking Status cancel: ".$row['ref_number']);
    }else{
        echo 0;
    }
	
}

?>