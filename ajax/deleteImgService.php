<?php
    include_once '../core/config.php';
	$img_id = $_POST['id'];
	
	$fetch_img = $mysqli_connect->query("SELECT service_img,service_id from tbl_service_img where img_id='$img_id'");
	$service_img = $fetch_img->fetch_array();

	$sql= $mysqli_connect->query("DELETE FROM `tbl_service_img` WHERE img_id='$img_id'");
	if($sql){
        unlink('../assets/service_img/'.$service_img[0]);
		// insert logs
		insertLogs($_SESSION['user_id'], "Remove service image: ".getService($service_img['service_id']));
		
		echo 1;
	}else{
		echo 0;
	}
?>