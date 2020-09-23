<?php
header("Access-Control-Allow-Origin: *");
require_once '../../core/config.php';

$name = $_POST['name'];
$email = $_POST['email'];
$contact_number = $_POST['contact_number'];
$address = $_POST['address'];
$username = $_POST['username'];
$password = $_POST['password'];

$checker = $mysqli_connect->query("SELECT * FROM tbl_users WHERE username='$username'");
if(mysqli_num_rows($checker) > 1){
    echo 2;
}else{
    $query = $mysqli_connect->query("INSERT INTO tbl_users SET user_type='C', name='$name', email='$email', contact_number='$contact_number', address='$address', username='$username', password=md5('$password')");

    if($query){
        echo 1;
    }else{
        echo 0;
    }
}

?>