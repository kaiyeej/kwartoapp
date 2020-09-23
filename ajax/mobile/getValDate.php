<?php
header("Access-Control-Allow-Origin: *");
require_once '../../core/config.php';
$user_id = $_POST['user_id'];

$fetchData = $mysqli_connect->query("SELECT * FROM tbl_reservation WHERE customer_id='$user_id' AND status='S'");
$row = $fetchData->fetch_array();

echo $row['start_date']."*".$row['end_date'];

?>

