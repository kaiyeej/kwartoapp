<?php
    include_once '../core/config.php';
	$file = rand(1000,100000)."-".$_FILES['file']['name'];
	$file_loc = $_FILES['file']['tmp_name'];
	$file_size = $_FILES['file']['size'];
	$file_type = $_FILES['file']['type'];
	$folder="../assets/service_img/";
	
	$hotel_id = $_SESSION['hotel_id'];

	$service_id = $_POST['service_id_img'];
	$fetch_service_img = $mysqli_connect->query("SELECT service_img,service FROM tbl_services WHERE service_id='$service_id'");
	$row = $fetch_service_img->fetch_array();

	// make file name in lower case	
	$new_file_name = strtolower($file);
	// make file name in lower case

	$img_file = str_replace(' ','-',$new_file_name);
	if(move_uploaded_file($file_loc,$folder.$img_file)){
		$sql= $mysqli_connect->query("INSERT INTO `tbl_service_img` SET `service_img`='$img_file',service_id='$service_id',hotel_id='$hotel_id'");
		if($sql){
            
			// insert logs
			insertLogs($_SESSION['user_id'], "Added service Image: ".$row[1]);
			
			echo 1;
		}else{
			echo 0;
		}
	}else{
		echo 0;
	}
?>