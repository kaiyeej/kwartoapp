<?php
header("Access-Control-Allow-Origin: *");

require_once '../../core/config.php';

if(isset($_POST['user_id'])){

	$user_id = $mysqli_connect->real_escape_string($_POST['user_id']);
    $hotel_id = $mysqli_connect->real_escape_string($_POST['hotel_id']);

    $mysqli_connect->query("UPDATE tbl_access_logs set status='P' WHERE user_id='$user_id' AND hotel_id='$hotel_id'");
}

?>