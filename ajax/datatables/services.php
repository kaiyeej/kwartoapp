<?php
require_once '../../core/config.php';

$fetchData = $mysqli_connect->query("SELECT * FROM tbl_services") or die(mysqli_error());

$response['data'] = array();
$count = 1;
while($row = $fetchData->fetch_array() ){
	$list = array();
	
    $list['id'] = $row['service_id'];
    $list['count'] = $count++;
    $list['checkbox'] = "<input type='checkbox' value=".$row['service_id']." class='service_id'>";
    $list['button'] = "<center><button style='font-size: 10px;width: 42px;' onclick='getEntryDetails(".$row['service_id'].")' class='btn btn-primary btn-xs'><span class='material-icons'>edit</span></button></center>";
    $list['hotel_id'] = getHotel($row['hotel_id']);
    $list['service'] = $row['service'];
	$list['description'] = $row['service_description'];
    $list['encoded_by'] = getUser($row['encoded_by']);

    $list['image'] = "<center><span style='font-size: 50px;color: #607D8B;' class='material-icons' onclick=showModalUpdateImg(".$row['service_id'].")>perm_media</span></center>";

	array_push($response['data'], $list);
}

echo json_encode($response);

?>