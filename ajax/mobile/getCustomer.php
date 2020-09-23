<?php
header("Access-Control-Allow-Origin: *");

require_once '../../core/config.php';

if(isset($_POST['userlogin']) && isset($_POST['userpassword'])){

	$username = $mysqli_connect->real_escape_string($_POST['userlogin']);
	$password = $mysqli_connect->real_escape_string($_POST['userpassword']);

	$response = array();
	$list = array();
	$fetch = $mysqli_connect->query("SELECT * from tbl_users where username='$username' and password=md5('$password') and user_type='C' ");

	if($fetch->num_rows > 0){
		$row = $fetch->fetch_assoc();
		$response = $row;

		echo json_encode($response);
	}else{
		$list['user_id'] = 0;
		$response = $list;

		echo json_encode($response);
	}

}else{
	echo "Cannot find POST data.";
}

?>