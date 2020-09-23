<?php
require_once '../core/config.php';
$hotel_name = $mysqli_connect->real_escape_string($_POST['hotel_name']);
$hotel_contact_number = $mysqli_connect->real_escape_string($_POST['hotel_contact_number']);
$hotel_email = $mysqli_connect->real_escape_string($_POST['hotel_email']);
$hotel_address = $mysqli_connect->real_escape_string($_POST['hotel_address']);
$hotel_description = $mysqli_connect->real_escape_string($_POST['hotel_description']);

$date = getCurrentDate();
$user_id = $_SESSION['user_id'];
$hotel_id = $_SESSION['hotel_id'];

$checker = $mysqli_connect->query("SELECT count(hotel_id) FROM tbl_hotels WHERE hotel_name='$hotel_name' AND hotel_id != '$hotel_id'") or die(mysqli_error());
$count_rows = $checker->fetch_array();
if($count_rows[0] > 0){
    echo 2;
}else{
    $sql = $mysqli_connect->query("UPDATE tbl_hotels SET hotel_name='$hotel_name',hotel_description='$hotel_description',hotel_address='$hotel_address',hotel_contact_number='$hotel_contact_number',hotel_email='$hotel_email' WHERE hotel_id='$hotel_id'") ;
    if($sql){
        echo 1;
        insertLogs($user_id, "Updated Hotel: ".$hotel_name);
    }else{
        echo 0;
    }
}

?>