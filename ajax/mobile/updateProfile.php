<?php
header("Access-Control-Allow-Origin: *");

require_once '../../core/config.php';

if(isset($_POST['user_id'])){

	$user_id = $mysqli_connect->real_escape_string($_POST['user_id']);
	$email = $mysqli_connect->real_escape_string($_POST['email']);
    $name = $mysqli_connect->real_escape_string($_POST['name']);
	$contact_number = $mysqli_connect->real_escape_string($_POST['contact_number']);
    $address = $mysqli_connect->real_escape_string($_POST['address']);

    $query = $mysqli_connect->query("UPDATE tbl_users SET name='$name',email='$email',contact_number='$contact_number',address='$address' WHERE user_id='$user_id'");

    if($query){
        echo 1;
    }else{
        echo 0;
    }

}

?>