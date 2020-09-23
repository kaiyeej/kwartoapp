<?php
    include_once '../core/config.php';
	$img_id = $_POST['id'];
	
	$fetch_img = $mysqli_connect->query("SELECT room_img,type_id from tbl_room_type_image where img_id='$img_id'");
	$room_img = $fetch_img->fetch_array();

	$sql= $mysqli_connect->query("DELETE FROM `tbl_room_type_image` WHERE img_id='$img_id'");
	if($sql){
        unlink('../assets/room_img/'.$room_img[0]);
		// insert logs
		insertLogs($_SESSION['user_id'], "Remove room image: ".getRoomType($room_img['type_id']));
		
		echo 1;
	}else{
		echo 0;
	}
?>