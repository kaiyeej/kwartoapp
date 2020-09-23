<?php
require_once '../core/config.php';
$type = $mysqli_connect->real_escape_string($_POST['type']);
$user_id = $mysqli_connect->real_escape_string($_POST['user_id']);
$hotel_id = $mysqli_connect->real_escape_string($_POST['hotel_id']);
$name = $mysqli_connect->real_escape_string($_POST['name']);
$email = $mysqli_connect->real_escape_string($_POST['email']);
$address = $mysqli_connect->real_escape_string($_POST['address']);
$contact_number = $mysqli_connect->real_escape_string($_POST['contact_number']);
$username = $mysqli_connect->real_escape_string($_POST['username']);
$password = $mysqli_connect->real_escape_string($_POST['password']);
$date = getCurrentDate();
$userID = $_SESSION['user_id'];

if($type == "add"){
    $checker = $mysqli_connect->query("SELECT * FROM tbl_users WHERE username='$username'") or die(mysqli_error());
    $count_rows = $checker->fetch_array();
    if($count_rows[0] > 0){
        echo 2;
    }else{
        $sql = $mysqli_connect->query("INSERT INTO tbl_users SET hotel_id='$hotel_id',user_type='A',name='$name',email='$email',contact_number='$contact_number',address='$address',username='$username',password=md5('$password'),encoded_by='$userID'") or die(mysqli_error());
        if($sql){
            echo 1;
            insertLogs($userID, "Added Account: ".$username);
        }else{
            echo 0;
        }
    }
}else{
    $checker = $mysqli_connect->query("SELECT * FROM tbl_users WHERE username='$username' AND user_id != '$user_id'") or die(mysqli_error());
    $count_rows = $checker->fetch_array();
    if($count_rows[0] > 0){
        echo 2;
    }else{
        if($password = -1){
            $pass_query = "";
        }else{
            $pass_query = ",password=md5('$password')";
        }
        $sql = $mysqli_connect->query("UPDATE tbl_users SET hotel_id='$hotel_id',name='$name',email='$email',contact_number='$contact_number',address='$address',username='$username' $pass_query WHERE hotel_id='$hotel_id' AND user_id='$user_id'") or die(mysqli_error());
        if($sql){
            echo 1;
            insertLogs($userID, "Updated Account: ".$username);
        }else{
            echo 0;
        }
    }
}

?>