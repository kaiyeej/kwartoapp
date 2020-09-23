<?php
    include_once '../core/config.php';
	$file = rand(1000,100000)."-".$_FILES['file']['name'];
	$file_loc = $_FILES['file']['tmp_name'];
	$file_size = $_FILES['file']['size'];
	$file_type = $_FILES['file']['type'];
	$folder="../assets/room_img/";
	
	$hotel_id = $_SESSION['hotel_id'];

	
	$type_id = $_POST['type_id_img'];
	$fetch_room_img = $mysqli_connect->query("SELECT room_img FROM tbl_room_type_image WHERE type_id='$type_id'");
	$row = $fetch_room_img->fetch_array();

	// make file name in lower case	
	$new_file_name = strtolower($file);
	// make file name in lower case

	$img_file = str_replace(' ','-',$new_file_name);
	if(move_uploaded_file($file_loc,$folder.$img_file)){
		$sql= $mysqli_connect->query("INSERT INTO `tbl_room_type_image` SET `room_img`='$img_file',type_id='$type_id',hotel_id='$hotel_id'");
		if($sql){
            /*if($row[0] != ""){
                unlink('../assets/room_img/'.$row[0]);
			}*/
			
			// insert logs
			insertLogs($_SESSION['user_id'], "Added room image: ".$row[1]);
			
			echo 1;
		}else{
			echo 0;
		}
	}else{
		echo 0;
	}
?>