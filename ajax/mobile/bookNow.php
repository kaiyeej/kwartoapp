<?php
header("Access-Control-Allow-Origin: *");

require_once '../../core/config.php';

if(isset($_POST['type_id'])){

	$type_id = $mysqli_connect->real_escape_string($_POST['type_id']);
	$start_date = $mysqli_connect->real_escape_string($_POST['start_date']);
    $end_date = $mysqli_connect->real_escape_string($_POST['end_date']);

    ini_set('date.timezone','UTC');
    date_default_timezone_set('UTC');
    $today = date('H:i:s');

    $date = getCurrentDate();
    $userID = $mysqli_connect->real_escape_string($_POST['user_id']);

    $ref_num = "REF-".date("njygis",strtotime($today)+28800);
    
    $fetchHotel = $mysqli_connect->query("SELECT hotel_id,room_rate FROM tbl_room_type WHERE type_id='$type_id'");
    $row = $fetchHotel->fetch_array();

    $days = daysDifference($end_date, $start_date);
    $amount = $row['room_rate']*$days;

    $countChecker = $mysqli_connect->query("SELECT count(reservation_id),ref_number FROM tbl_reservation WHERE hotel_id='$row[hotel_id]' AND start_date='$start_date' AND end_date='$end_date' AND customer_id='$userID'");
    $counter = $countChecker->fetch_array();
    if($counter[0] == 0){
        $mysqli_connect->query("INSERT INTO tbl_reservation SET ref_number='$ref_num', hotel_id='$row[hotel_id]', customer_id='$userID', start_date='$start_date', end_date='$end_date', date_added='$date', status='S', reservation_type='M'");

        $query = $mysqli_connect->query("INSERT INTO tbl_reservation_details SET ref_number='$ref_num', type='R',type_id='$type_id', amount='$amount', status='S'");

    }else{
        $query = $mysqli_connect->query("INSERT INTO tbl_reservation_details SET ref_number='$counter[ref_number]',type_id='$type_id', type='R', amount='$amount', status='S'");
    }

    if($query){
        echo 1;
    }else{
        echo 0;
    }

}

?>