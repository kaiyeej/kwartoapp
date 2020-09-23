<?php
require_once '../core/config.php';
$type = $mysqli_connect->real_escape_string($_POST['type']);
$type_id = $mysqli_connect->real_escape_string($_POST['type_id']);
$remarks = $mysqli_connect->real_escape_string($_POST['remarks']);
$hotel_id = $mysqli_connect->real_escape_string($_POST['hotel_id']);
$room_type = $mysqli_connect->real_escape_string($_POST['room_type']);
$capacity = $mysqli_connect->real_escape_string($_POST['capacity']);
$room_rate = $mysqli_connect->real_escape_string($_POST['room_rate']);
$date = getCurrentDate();
$user_id = $_SESSION['user_id'];

if($type == "add"){
    $checker = $mysqli_connect->query("SELECT * FROM tbl_room_type WHERE room_type='$room_type' AND hotel_id='$hotel_id'") or die(mysqli_error());
    $count_rows = $checker->fetch_array();
    if($count_rows[0] > 0){
        echo 2;
    }else{
        $sql = $mysqli_connect->query("INSERT INTO tbl_room_type SET remarks='$remarks',hotel_id='$hotel_id',room_type='$room_type',date_added='$date',encoded_by='$user_id',capacity='$capacity',room_rate='$room_rate'") or die(mysqli_error());
        if($sql){
            echo 1;
            insertLogs($user_id, "Added Room Type: ".$room_type);
        }else{
            echo 0;
        }
    }
}else{
    $checker = $mysqli_connect->query("SELECT * FROM tbl_room_type WHERE room_type='$room_type' AND type_id != '$type_id'") or die(mysqli_error());
    $count_rows = $checker->fetch_array();
    if($count_rows[0] > 0){
        echo 2;
    }else{
        $sql = $mysqli_connect->query("UPDATE tbl_room_type SET remarks='$remarks',hotel_id='$hotel_id',room_type='$room_type',capacity='$capacity',room_rate='$room_rate' WHERE type_id='$type_id'") or die(mysqli_error());
        if($sql){
            echo 1;
            insertLogs($user_id, "Updated Room Type: ".$room_type);
        }else{
            echo 0;
        }
    }
}

?>