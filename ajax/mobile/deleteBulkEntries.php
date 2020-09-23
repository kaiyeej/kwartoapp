<?php
header("Access-Control-Allow-Origin: *");
require_once '../../core/config.php';

if(isset($_POST['id'])){
	$id = $mysqli_connect->real_escape_string($_POST['id']);
	$table = $_POST['tb'];
	$keyword = $_POST['keyword'];
    
    if($keyword == "reservation_id"){
        $type = "H";
    }else{
        $type = "D";
    }

    $ref_number = getRefNum($id,$type);

	$sql = $mysqli_connect->query("DELETE from $table where $keyword='$id' ") or die(mysqli_error());

	if($sql){
        if($keyword == "reservation_id"){
            $mysqli_connect->query("DELETE from tbl_reservation_details where ref_number='$ref_number' ") or die(mysqli_error());
        }else{
            $checker = $mysqli_connect->query("SELECT count(rsd_id) FROM tbl_reservation_details where ref_number='$ref_number'") or die(mysqli_error());
            $counter = $checker->fetch_array();
            if($counter[0] == 0){
                $mysqli_connect->query("DELETE from tbl_reservation where ref_number='$ref_number'") or die(mysqli_error());
            }
        }

		echo 1;
	}else{
		echo 0;
	}

	$mysqli_connect->close();
	
}

?>