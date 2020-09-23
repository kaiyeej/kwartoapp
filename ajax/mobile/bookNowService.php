<?php
header("Access-Control-Allow-Origin: *");

require_once '../../core/config.php';

if(isset($_POST['service_id'])){

	$service_id = $mysqli_connect->real_escape_string($_POST['service_id']);

    ini_set('date.timezone','UTC');
    date_default_timezone_set('UTC');
    $today = date('H:i:s');

    $date = getCurrentDate();
    $userID = $mysqli_connect->real_escape_string($_POST['user_id']);

    $ref_num = "REF-".date("njygis",strtotime($today)+28800);
    
    $fetchService = $mysqli_connect->query("SELECT hotel_id,service_rate FROM tbl_services WHERE service_id='$service_id'");
    $row = $fetchService->fetch_array();

    $amount = $row['service_rate'];

    $countChecker = $mysqli_connect->query("SELECT count(reservation_id),ref_number FROM tbl_reservation WHERE hotel_id='$row[hotel_id]' AND status='S' AND customer_id='$userID'");
    $counter = $countChecker->fetch_array();
    if($counter[0] == 0){
        echo 2; 
    }else{
        $query = $mysqli_connect->query("INSERT INTO tbl_reservation_details SET ref_number='$counter[ref_number]',service_id='$service_id', type='S', amount='$amount', status='S'");

        if($query){
            echo 1;
        }else{
            echo 0;
        }
    }

}

?>