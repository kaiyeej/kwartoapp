<?php
require_once '../core/config.php';
$service_type = $mysqli_connect->real_escape_string($_POST['service_type']);
$service_id = $mysqli_connect->real_escape_string($_POST['service_id']);
$qty = $mysqli_connect->real_escape_string($_POST['qty']);

if($service_type == "S"){
    $price = getServicePrice($service_id);
}else{
    $price = getRoomPrice($service_id);
}

echo number_format(($price*$qty),2);
?>