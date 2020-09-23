<?php
require_once '../../core/config.php';

$fetchData = $mysqli_connect->query("SELECT * FROM tbl_room_type") or die(mysqli_error());

$response['data'] = array();
$count = 1;
while($row = $fetchData->fetch_array() ){
	$list = array();
	
    $list['id'] = $row['type_id'];
    $list['count'] = $count++;
    $list['checkbox'] = "<input type='checkbox' value=".$row['type_id']." class='type_id'>";
    $list['button'] = "<center><button type='button' rel='tooltip' onclick='getEntryDetails(".$row['type_id'].")' class='btn btn-primary btn-round'><span class='material-icons'>edit</span></button></center>";
    $list['hotel_id'] = getHotel($row['hotel_id']);
    $list['room_type'] = $row['room_type'];
	$list['description'] = $row['remarks'];
    $list['encoded_by'] = getUser($row['encoded_by']);

    //"<img src='assets/room_img/".$row['room_img']."' style='width:200px;'></div>

    $list['image'] = "<center><span style='font-size: 50px;color: #607D8B;' class='material-icons' onclick=showModalUpdateImg(".$row['type_id'].")>perm_media</span></center>";
    
	array_push($response['data'], $list);
}

echo json_encode($response);

?>