<?php
require_once '../../core/config.php';
$user_type = $_SESSION['user_type'];
$status_type = $_POST['status_type'];
$hotel_id = $_SESSION['hotel_id'];

if($user_type == "S"){
    if($status_type == "all"){
        $query = "";
    }else if($status_type == 1){
        $query = "WHERE status='1'";
    }else{
        $query = "WHERE status='0'";
    }
}else if($user_type == "A"){
    if($status_type == "all"){
        $query = "WHERE hotel_id='$hotel_id'";
    }else if($status_type == 1){
        $query = "WHERE hotel_id='$hotel_id' AND status='1'";
    }else{
        $query = "WHERE hotel_id='$hotel_id' AND status='0'";
    }
}


$fetchData = $mysqli_connect->query("SELECT * FROM tbl_rooms $query") or die(mysqli_error());

$response['data'] = array();
$count = 1;
while($row = $fetchData->fetch_array() ){
	$list = array();
    
    if($row['status'] != 1){
        $status = "<strong style='color:green;'>Vacant</strong>";
    }else{
        $status = "<strong style='color:orange;'>OCCUPIED</strong>";
    }
    
    $list['id'] = $row['room_id'];
    $list['count'] = $count++;
    $list['room'] = $row['room_name'];
    $list['checkbox'] = "<input type='checkbox' value=".$row['room_id']." class='room_id'>";
    $list['button'] = "<center><button style='font-size: 10px;width: 42px;' onclick='getEntryDetails(".$row['room_id'].")' class='btn btn-primary btn-xs'><span class='material-icons'>edit</span></button></center>";
    $list['hotel_id'] = getHotel($row['hotel_id']);
    $list['room_type'] = getRoomType($row['type_id']);
	$list['description'] = $row['room_description'];
    $list['encoded_by'] = getUser($row['encoded_by']);
    
    $list['status'] = $status;

    if(empty($row['room_img'])){
        $list['image'] = "<img style='width:100px;' class='img-responsive' src='assets/room_img/no_img.jpg'  onclick=showModalUpdateImg(".$row['room_id'].",'no_img.jpg')>";
    }else{
        $list['image'] = "<img style='width:100px;' class='img-responsive' src='assets/room_img/".$row['room_img']."'  onclick=showModalUpdateImg(".$row['room_id'].",'".$row['room_img']."')>";
    }

	array_push($response['data'], $list);
}

echo json_encode($response);

?>