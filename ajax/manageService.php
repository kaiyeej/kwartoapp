<?php
require_once '../core/config.php';
$type = $mysqli_connect->real_escape_string($_POST['type']);
$service_id = $mysqli_connect->real_escape_string($_POST['service_id']);
$service_description = $mysqli_connect->real_escape_string($_POST['service_description']);
$hotel_id = $mysqli_connect->real_escape_string($_POST['hotel_id']);
$service = $mysqli_connect->real_escape_string($_POST['service']);
$service = $mysqli_connect->real_escape_string($_POST['service']);
$service_rate = $mysqli_connect->real_escape_string($_POST['service_rate']);
$date = getCurrentDate();
$user_id = $_SESSION['user_id'];

if($type == "add"){
    $checker = $mysqli_connect->query("SELECT * FROM tbl_services WHERE service='$service' AND hotel_id='$hotel_id'") or die(mysqli_error());
    $count_rows = $checker->fetch_array();
    if($count_rows[0] > 0){
        echo 2;
    }else{
        $sql = $mysqli_connect->query("INSERT INTO tbl_services SET service_description='$service_description',hotel_id='$hotel_id',service='$service',date_added='$date',encoded_by='$user_id',service_rate='$service_rate'") or die(mysqli_error());
        if($sql){
            echo 1;
            insertLogs($user_id, "Added Service: ".$service);
        }else{
            echo 0;
        }
    }
}else{
    $checker = $mysqli_connect->query("SELECT * FROM tbl_services WHERE service='$service' AND service_id != '$service_id'") or die(mysqli_error());
    $count_rows = $checker->fetch_array();
    if($count_rows[0] > 0){
        echo 2;
    }else{
        $sql = $mysqli_connect->query("UPDATE tbl_services SET service_description='$service_description',hotel_id='$hotel_id',service='$service',service_rate='$service_rate' WHERE service_id='$service_id'") or die(mysqli_error());
        if($sql){
            echo 1;
            insertLogs($user_id, "Updated Service: ".$service);
        }else{
            echo 0;
        }
    }
}

?>