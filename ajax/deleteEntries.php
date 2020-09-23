<?php
require_once '../core/config.php';

if(isset($_POST['id'])){
	//$id = $mysqli_connect->real_escape_string($_POST['id']);
	$table = $_POST['tb'];
    $keyword = $_POST['keyword'];
	$id = $_POST['id'];

	$sql = $mysqli_connect->query("DELETE from $table where $keyword='$id' ") or die(mysqli_error());

	if($sql){
        echo 1;
        
	}else{
		echo 0;
	}

	$mysqli_connect->close();
	
}

?>