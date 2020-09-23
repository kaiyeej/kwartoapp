<?php
require_once '../core/config.php';
$id = $mysqli_connect->real_escape_string($_POST['id']);
$room_id = $mysqli_connect->real_escape_string($_POST['room_id']);

$date = getCurrentDate();
$userID = $_SESSION['user_id'];

$sql = $mysqli_connect->query("UPDATE tbl_reservation_details SET room_id='$room_id' WHERE rsd_id='$id'") or die(mysqli_error());
if($sql){
    echo 1;
    $ref_number = getRefNum($id,"D");
    $room = getRoom($room_id);
    insertLogs($userID, "Assigned Room: ".$room." (".$ref_number."))");
}else{
    echo 0;
}
?>