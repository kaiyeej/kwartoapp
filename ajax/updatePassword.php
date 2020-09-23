<?php
require_once '../core/config.php';
$old_password = $mysqli_connect->real_escape_string($_POST['old_password']);
$new_password = $mysqli_connect->real_escape_string($_POST['new_password']);
$confirm_password = $mysqli_connect->real_escape_string($_POST['confirm_password']);
$date = getCurrentDate();
$user_id = $_SESSION['user_id'];

$fetchPass = $mysqli_connect->query("SELECT count(user_id) FROM tbl_users WHERE user_id='$user_id' AND password=md5('$old_password')");
$checker = $fetchPass->fetch_array();

if($checker[0] == 0){
    echo 2;
}else{
    $query = $mysqli_connect->query("UPDATE tbl_users SET password=md5('$new_password') WHERE user_id='$user_id'");
    if($query){
        insertLogs($user_id, "Updated Password");
        echo 1;
    }else{
        echo 0;
    }
}

?>