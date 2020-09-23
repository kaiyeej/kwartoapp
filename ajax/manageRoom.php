<?php
require_once '../core/config.php';
$type = $mysqli_connect->real_escape_string($_POST['type']);
$room_id = $mysqli_connect->real_escape_string($_POST['room_id']);
$room_name = $mysqli_connect->real_escape_string($_POST['room_name']);
$room_description = $mysqli_connect->real_escape_string($_POST['room_description']);
$room_type = $mysqli_connect->real_escape_string($_POST['room_type']);
$room_rate = $mysqli_connect->real_escape_string($_POST['room_rate']);
$hotel_id = $mysqli_connect->real_escape_string($_POST['hotel_id']);
$date = getCurrentDate();
$user_id = $_SESSION['user_id'];

if($type == "add"){
    $checker = $mysqli_connect->query("SELECT * FROM tbl_rooms WHERE room_name='$room_name' AND hotel_id='$hotel_id'") or die(mysqli_error());
    $count_rows = $checker->fetch_array();
    if($count_rows[0] > 0){
        echo 2;
    }else{
        $sql = $mysqli_connect->query("INSERT INTO tbl_rooms SET room_name='$room_name',room_description='$room_description',type_id='$room_type',room_rate='$room_rate',date_added='$date',encoded_by='$user_id',hotel_id='$hotel_id'") or die(mysqli_error());
        if($sql){
            echo 1;
            insertLogs($user_id, "Added Room: ".$room_name);
        }else{
            echo 0;
        }
    }
}else{
    $checker = $mysqli_connect->query("SELECT * FROM tbl_rooms WHERE room_name='$room_name' AND room_id != '$room_id'") or die(mysqli_error());
    $count_rows = $checker->fetch_array();
    if($count_rows[0] > 0){
        echo 2;
    }else{
        $sql = $mysqli_connect->query("UPDATE tbl_rooms SET room_name='$room_name',room_description='$room_description',type_id='$room_type',room_rate='$room_rate',hotel_id='$hotel_id' WHERE room_id='$room_id'") or die(mysqli_error());
        if($sql){
            echo 1;
            insertLogs($user_id, "Updated Room: ".$room_name);
        }else{
            echo 0;
        }
    }
}

?>