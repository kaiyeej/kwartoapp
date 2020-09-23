<?php
require_once '../../core/config.php';

$fetchData = $mysqli_connect->query("SELECT * FROM tbl_hotels ORDER BY hotel_name ASC") or die(mysqli_error());

$response['data'] = array();
$count = 1;
while($row = $fetchData->fetch_array() ){
	$list = array();
	
    $list['id'] = $row['hotel_id'];
    $list['count'] = $count++;
    $list['hotel'] = $row['hotel_name'];
    $list['checkbox'] = "<input type='checkbox' value=".$row['hotel_id']." class='hotel_id'>";
    $list['button'] = "<center><button style='font-size: 10px;width: 42px;' onclick='getEntryDetails(".$row['hotel_id'].")' class='btn btn-primary btn-xs'><span class='material-icons'>edit</span></button></center>";
    $list['description'] = $row['hotel_description'];
    $list['address'] = $row['hotel_address'];
	$list['contact_no'] = $row['hotel_contact_number'];
    $list['encoded_by'] = getUser($row['encoded_by']);
    if(empty($row['hotel_img'])){
        $list['image'] = "<img style='width:100px;' class='img-responsive' src='assets/hotel_img/no_img.jpg'  onclick=showModalUpdateImg(".$row['hotel_id'].",'no_img.jpg')>";
    }else{
        $list['image'] = "<img style='width:100px;' class='img-responsive' src='assets/hotel_img/".$row['hotel_img']."'  onclick=showModalUpdateImg(".$row['hotel_id'].",'".$row['hotel_img']."')>";
    }
    

	array_push($response['data'], $list);
}

echo json_encode($response);

?>