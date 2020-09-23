<?php
    include_once '../core/config.php';
    $service_id = $_POST['id'];
    
	$fetchImg = $mysqli_connect->query("SELECT * FROM tbl_service_img WHERE service_id='$service_id'");
    $albm_img = "";
    while($ablRow = $fetchImg->fetch_array()){
        $i_m_g = 'assets/service_img/'.$ablRow['service_img'];
        $albm_img .= "<div style='padding: 20px;' class='col-md-6'><img src='$i_m_g' style='width:100%;'><button onclick='removeIMG(".$ablRow['img_id'].",".$ablRow['service_id'].")' style='font-size: 12px;margin-top: 0px;margin-left: -1px;width:100%;' class='btn btn-danger'> <center><span class='material-icons'>delete_outline</span> Remove</center></button></div>";
    }

echo $albm_img;
?>