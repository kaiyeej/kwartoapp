<?php
require_once '../../core/config.php';

$fetchData = $mysqli_connect->query("SELECT * FROM tbl_logs ORDER by log_id DESC") or die(mysqli_error());

$response['data'] = array();
$count = 1;
while($row = $fetchData->fetch_array() ){
	$list = array();
	
    $list['id'] = $row['log_id'];
    $list['count'] = $count++;
    $list['action'] = $row['action'];
    $list['date_added'] = date('F d, Y h:m A',strtotime($row["date_added"]));
    $list['user'] = getUser($row['user_id']);

	array_push($response['data'], $list);
}

echo json_encode($response);

?>