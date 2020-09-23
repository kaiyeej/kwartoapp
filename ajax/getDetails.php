<?php
require_once '../core/config.php';

if(isset($_POST['id'])){
	$id = $_POST['id'];
	$table = $_POST['tb'];
	$keyword = $_POST['keyword'];


	$fetch_row = $mysqli_connect->query("SELECT * from $table where $keyword='$id'") or die(mysqli_error());

	$response['data'] = array();

	$response = $fetch_row->fetch_array();

	echo json_encode($response);


	$mysqli_connect->close();
	
}

?>