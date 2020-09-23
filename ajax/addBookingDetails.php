<?php
require_once '../core/config.php';
$service_type = $mysqli_connect->real_escape_string($_POST['service_type']);
$service = $mysqli_connect->real_escape_string($_POST['service_id']);
$hotel_id = $_SESSION['hotel_id'];
$qty = $mysqli_connect->real_escape_string($_POST['qty']);

$ref_number = $mysqli_connect->real_escape_string($_POST['ref_number']);

$date = getCurrentDate();
$userID = $_SESSION['user_id'];

if($service_type == "S"){
    $amount = getServicePrice($service);
    $type_id = "";
    $room_id = "";
    $service_id = $service;
}else{
    $amount = getRoomPrice($service);
    $type_id = getRoomType($service);
    $room_id = $service;
    $service_id = "";
}

$fetchHeader = $mysqli_connect->query("SELECT * FROM tbl_reservation WHERE ref_number='$ref_number'");
$row = $fetchHeader->fetch_array();

$room_status = roomStatus($room_id,$row['start_date'],$row['end_date']);
if($room_status > 0 AND $service_type == "R"){
    echo 2;
}else{
    $sql = $mysqli_connect->query("INSERT INTO tbl_reservation_details SET ref_number='$ref_number',type='$service_type',room_id='$room_id',service_id='$service_id',qty='$qty',amount='$amount',status='A',type_id='$type_id'") or die(mysqli_error());
    if($sql){
        echo 1;
        insertLogs($userID, "Added Booking Details: ".$ref_number);
    }else{
        echo 0;
    }
}

?>