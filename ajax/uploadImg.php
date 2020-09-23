<?php
    include_once '../core/config.php';
	$file = rand(1000,100000)."-".$_FILES['file']['name'];
	$file_loc = $_FILES['file']['tmp_name'];
	$file_size = $_FILES['file']['size'];
	$file_type = $_FILES['file']['type'];
	$folder="../assets/hotel_img/";
	
	$user_type = $_SESSION['user_type'];
	if($user_type == "S"){
		$hotel_id = $_POST['hotel_id_mg'];
	}else{
		$hotel_id = $_SESSION['hotel_id'];
	}
	
	$fetch_hotel_img = $mysqli_connect->query("SELECT hotel_img, hotel_name from tbl_hotels where hotel_id='$hotel_id'");
	$hotel_img = $fetch_hotel_img->fetch_array();


	// make file name in lower case	
	$new_file_name = strtolower($file);
	// make file name in lower case

	$img_file = str_replace(' ','-',$new_file_name);
	if(move_uploaded_file($file_loc,$folder.$img_file)){
		$sql= $mysqli_connect->query("UPDATE `tbl_hotels` SET `hotel_img`='$img_file' WHERE hotel_id='$hotel_id'");
		if($sql){
            if($hotel_img[0] != ""){
                unlink('../assets/hotel_img/'.$hotel_img[0]);
			}
			
			// insert logs
			insertLogs($_SESSION['user_id'], "Updated hotel image");
			
			echo 1;
		}else{
			echo 0;
		}
	}else{
		echo 0;
	}
?>