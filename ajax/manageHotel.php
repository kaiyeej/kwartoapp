<?php
require_once '../core/config.php';
$type = $mysqli_connect->real_escape_string($_POST['type']);
$hotel_id = $mysqli_connect->real_escape_string($_POST['hotel_id']);
$hotel_name = $mysqli_connect->real_escape_string($_POST['hotel_name']);
$hotel_address = $mysqli_connect->real_escape_string($_POST['hotel_address']);
$hotel_contact_number = $mysqli_connect->real_escape_string($_POST['hotel_contact_number']);
$hotel_email = $mysqli_connect->real_escape_string($_POST['hotel_email']);
$hotel_description = $mysqli_connect->real_escape_string($_POST['hotel_description']);
$date = getCurrentDate();
$user_id = $_SESSION['user_id'];

if($type == "add"){
    $checker = $mysqli_connect->query("SELECT * FROM tbl_hotels WHERE hotel_name='$hotel_name'") or die(mysqli_error());
    $count_rows = $checker->fetch_array();
    if($count_rows[0] > 0){
        echo 2;
    }else{
        $sql = $mysqli_connect->query("INSERT INTO tbl_hotels SET hotel_name='$hotel_name',hotel_description='$hotel_description',hotel_address='$hotel_address',hotel_contact_number='$hotel_contact_number',hotel_email='$hotel_email',date_added='$date',encoded_by='$user_id'") or die(mysqli_error());
        if($sql){
            echo 1;
            insertLogs($user_id, "Added Hotel: ".$hotel_name);
        }else{
            echo 0;
        }
    }
}else{
    $checker = $mysqli_connect->query("SELECT * FROM tbl_hotels WHERE hotel_name='$hotel_name' AND hotel_id != '$hotel_id'") or die(mysqli_error());
    $count_rows = $checker->fetch_array();
    if($count_rows[0] > 0){
        echo 2;
    }else{
        $sql = $mysqli_connect->query("UPDATE tbl_hotels SET hotel_name='$hotel_name',hotel_description='$hotel_description',hotel_address='$hotel_address',hotel_contact_number='$hotel_contact_number',hotel_email='$hotel_email' WHERE hotel_id='$hotel_id'") or die(mysqli_error());
        if($sql){
            echo 1;
            insertLogs($user_id, "Updated Hotel: ".$hotel_name);
        }else{
            echo 0;
        }
    }
}

?>