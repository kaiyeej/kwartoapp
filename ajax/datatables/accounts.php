<?php
require_once '../../core/config.php';

$user_type = $_SESSION['user_type'];
if($user_type == "S"){
    $query = "";
}else if($user_type == "A"){
    $query = "WHERE user_type='A'";
}

$fetchData = $mysqli_connect->query("SELECT * FROM tbl_users $query") or die(mysqli_error());

$response['data'] = array();
$count = 1;
while($row = $fetchData->fetch_array() ){
    $list = array();
    
    if($row['user_type'] == "A"){
        $account_type = "Admin";
    }else if($row['user_type'] == "S"){
        $account_type = "Super Admin";
    }else{
        $account_type = "Customer";
    }
	
    $list['id'] = $row['user_id'];
    $list['count'] = $count++;
    $list['checkbox'] = "<input type='checkbox' value=".$row['user_id']." class='user_id'>";
    $list['button'] = "<center><button style='font-size: 10px;width: 42px;' onclick='getEntryDetails(".$row['user_id'].")' class='btn btn-primary btn-xs'><span class='material-icons'>edit</span></button></center>";
    $list['hotel_id'] = getHotel($row['hotel_id']);
    $list['account_type'] = $account_type;
	$list['name'] = $row['name'];
    $list['encoded_by'] = getUser($row['encoded_by']);

	array_push($response['data'], $list);
}

echo json_encode($response);

?>