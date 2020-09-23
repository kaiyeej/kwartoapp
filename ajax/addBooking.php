<?php
require_once '../core/config.php';
$type = $mysqli_connect->real_escape_string($_POST['type']);
$customer_type = $mysqli_connect->real_escape_string($_POST['customer_type']);
$hotel_id = $_SESSION['hotel_id'];
$customer = $mysqli_connect->real_escape_string($_POST['customer_id']);
$start_date = $mysqli_connect->real_escape_string($_POST['start_date']);
$end_date = $mysqli_connect->real_escape_string($_POST['end_date']);
$type_id = $mysqli_connect->real_escape_string($_POST['type_id']);
$room_id = $mysqli_connect->real_escape_string($_POST['room_id']);

$ref_number = $mysqli_connect->real_escape_string($_POST['ref_number']);

$date = getCurrentDate();
$userID = $_SESSION['user_id'];

if($customer_type == "1"){
    $walk_in = $customer;
    $customer_id = "";
}else{
    $walk_in = "";
    $customer_id = $customer;
}

$amount = getRoomPrice($room_id);

if($type == "add"){
    $room_status = roomStatus($room_id,$start_date,$end_date);
    if($room_status > 0){
        echo 2;
    }else{
        $sql = $mysqli_connect->query("INSERT INTO tbl_reservation SET ref_number='$ref_number',hotel_id='$hotel_id',walk_in='$walk_in',customer_id='$customer_id',start_date='$start_date',end_date='$end_date',status='A',date_added='$date',approved_by='$userID',approved_date='$date'") or die(mysqli_error());
        if($sql){
            $mysqli_connect->query("INSERT INTO tbl_reservation_details SET ref_number='$ref_number',type='R',type_id='$type_id',room_id='$room_id',qty='1',amount='$amount',status='A'") or die(mysqli_error());
            echo 1;
            insertLogs($userID, "Added New Booking: ".$ref_number);
        }else{
            echo 0;
        }
    }
}else{
    /*$checker = $mysqli_connect->query("SELECT * FROM tbl_users WHERE username='$username' AND user_id != '$user_id'") or die(mysqli_error());
    $count_rows = $checker->fetch_array();
    if($count_rows[0] > 0){
        echo 2;
    }else{
        if($password = -1){
            $pass_query = "";
        }else{
            $pass_query = ",password=md5('$password')";
        }
        $sql = $mysqli_connect->query("UPDATE tbl_users SET hotel_id='$hotel_id',name='$name',email='$email',contact_number='$contact_number',address='$address',username='$username' $pass_query WHERE hotel_id='$hotel_id'") or die(mysqli_error());
        if($sql){
            echo 1;
            insertLogs($userID, "Updated Account: ".$username);
        }else{
            echo 0;
        }
    }*/
}

?>