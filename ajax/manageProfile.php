<?php
require_once '../core/config.php';
$name = $mysqli_connect->real_escape_string($_POST['name']);
$username = $mysqli_connect->real_escape_string($_POST['username']);
$contact_number = $mysqli_connect->real_escape_string($_POST['contact_number']);
$email = $mysqli_connect->real_escape_string($_POST['email']);
$address = $mysqli_connect->real_escape_string($_POST['address']);

$date = getCurrentDate();
$user_id = $_SESSION['user_id'];


$checker = $mysqli_connect->query("SELECT * FROM tbl_users WHERE username='$username' AND user_id != '$user_id'") or die(mysqli_error());
$count_rows = $checker->fetch_array();
if($count_rows[0] > 0){
    echo 2;
}else{
    $sql = $mysqli_connect->query("UPDATE tbl_users SET name='$name', username='$username', contact_number='$contact_number', email='$email', address='$address' WHERE user_id='$user_id'") or die(mysqli_error());
    if($sql){
        echo 1;
        insertLogs($user_id, "Updated User Profile");
    }else{
        echo 0;
    }
}

?>