<?php


function getCurrentDate(){
	ini_set('date.timezone','UTC');
	//error_reporting(E_ALL);
	date_default_timezone_set('UTC');
	$today = date('H:i:s');
	$system_date = date('Y-m-d H:i:s', strtotime($today)+28800);
	return $system_date;
}

function insertLogs($user_id, $action){
	global $mysqli_connect;
	$date = getCurrentDate();
	$mysqli_connect->query("INSERT INTO `tbl_logs`(`user_id`, `action`, `date_added`) VALUES ('$user_id','$action','$date')");
}

function insertNotif($customer_id, $message, $type,$hotel_id){
	global $mysqli_connect;
	$date = getCurrentDate();
	$mysqli_connect->query("INSERT INTO `tbl_notifications`(`message`, `type`, `user_id`,hotel_id,date_added) VALUES ('$message','$type','$customer_id','$hotel_id','$date')");
}

function getUser($user_id){
	global $mysqli_connect;
	$fetch_row = $mysqli_connect->query("SELECT name FROM tbl_users WHERE user_id='$user_id'");
	$data = $fetch_row->fetch_array();

	return $data[0];
}

function getRoomType($type_id){
	global $mysqli_connect;
	$fetch_row = $mysqli_connect->query("SELECT room_type FROM tbl_room_type WHERE type_id='$type_id'");
	$data = $fetch_row->fetch_array();

	return $data[0];
}

function getRoom_type($room_id){
	global $mysqli_connect;
	$fetch_row = $mysqli_connect->query("SELECT type_id FROM tbl_rooms WHERE room_id='$room_id'");
	$data = $fetch_row->fetch_array();

	return $data[0];
}


function getRoomCapacity($type_id){
	global $mysqli_connect;
	$fetch_row = $mysqli_connect->query("SELECT capacity FROM tbl_room_type WHERE type_id='$type_id'");
	$data = $fetch_row->fetch_array();

	return $data[0];
}

function getRoom($room_id){
	global $mysqli_connect;
	$fetch_row = $mysqli_connect->query("SELECT room_name FROM tbl_rooms WHERE room_id='$room_id'");
	$data = $fetch_row->fetch_array();

	return $data[0];
}

function getHotel($hotel_id){
	global $mysqli_connect;
	$fetch_row = $mysqli_connect->query("SELECT hotel_name FROM tbl_hotels WHERE hotel_id='$hotel_id'");
	$data = $fetch_row->fetch_array();

	return $data[0];
}


function getHotelDesc($hotel_id){
	global $mysqli_connect;
	$fetch_row = $mysqli_connect->query("SELECT hotel_description FROM tbl_hotels WHERE hotel_id='$hotel_id'");
	$data = $fetch_row->fetch_array();

	return $data[0];
}

function roomStatus($room_id,$arrival_date,$departure_date){
	global $mysqli_connect;
	$hotel_id = $_SESSION['hotel_id'];
	$fetch_row = $mysqli_connect->query("SELECT count(reservation_id) FROM tbl_reservation as r, tbl_reservation_details as rd WHERE rd.ref_number=r.ref_number AND rd.room_id='$room_id' AND (r.start_date >= '$arrival_date' AND r.end_date <= '$departure_date') AND r.hotel_id='$hotel_id' AND r.status!='F'");
	$data = $fetch_row->fetch_array();

	return $data[0];
}

function room_status($type_id,$arrival_date,$departure_date){
	global $mysqli_connect;
	$fetchRoom = $mysqli_connect->query("SELECT * FROM tbl_rooms WHERE type_id='$type_id'");
	$counter = 0;
	$checker = 0;
	while($row = $fetchRoom->fetch_array()){
		$fetch_row = $mysqli_connect->query("SELECT count(reservation_id) FROM tbl_reservation as r, tbl_reservation_details as rd WHERE rd.ref_number=r.ref_number AND rd.room_id='$row[room_id]' AND (r.start_date >= '$arrival_date' AND r.end_date <= '$departure_date') AND r.status!='F'");
		$data = $fetch_row->fetch_array();
		$counter += 1;
		$checker += $data[0];
	}
	
	if($counter <= $checker){
		return 1;
	}else{
		return $checker;
	}
}

function availableRoom($capacity,$arrival_date,$departure_date,$hotel_id){
	global $mysqli_connect;
	$fetchRoom = $mysqli_connect->query("SELECT * FROM tbl_room_type WHERE capacity='$capacity' AND hotel_id='$hotel_id'");
	$occupied = 0;
	$total_room = 0;
	while($row = $fetchRoom->fetch_array()){
		$fetch_row = $mysqli_connect->query("SELECT count(reservation_id) FROM tbl_reservation as r, tbl_reservation_details as rd WHERE rd.ref_number=r.ref_number AND rd.type_id='$row[type_id]' AND (r.start_date >= '$arrival_date' AND r.end_date <= '$departure_date') AND r.status!='F'");
		$data = $fetch_row->fetch_array();
		$occupied += $data[0];
		$total_room += 1;
	}

	return $total_room-$occupied;
}

function getRoomPrice($room_id){
	global $mysqli_connect;
	$fetch_row = $mysqli_connect->query("SELECT room_rate FROM tbl_rooms WHERE room_id='$room_id'");
	$data = $fetch_row->fetch_array();

	return $data[0];
}

function getService($service_id){
	global $mysqli_connect;
	$fetch_row = $mysqli_connect->query("SELECT service FROM tbl_services WHERE service_id='$service_id'");
	$data = $fetch_row->fetch_array();

	return $data[0];
}

function getServicePrice($service_id){
	global $mysqli_connect;
	$fetch_row = $mysqli_connect->query("SELECT service_rate FROM tbl_services WHERE service_id='$service_id'");
	$data = $fetch_row->fetch_array();

	return $data[0];
}

function totalRoom(){
	global $mysqli_connect;
	$hotel_id = $_SESSION['hotel_id'];
	$fetch_row = $mysqli_connect->query("SELECT count(room_id) FROM tbl_rooms WHERE hotel_id='$hotel_id'");
	$data = $fetch_row->fetch_array();

	return $data[0];
}

function total_room($hotel_id){
	global $mysqli_connect;
	$fetch_row = $mysqli_connect->query("SELECT count(room_id) FROM tbl_rooms WHERE hotel_id='$hotel_id'");
	$data = $fetch_row->fetch_array();

	return $data[0];
}

function total_service($hotel_id){
	global $mysqli_connect;
	$fetch_row = $mysqli_connect->query("SELECT count(service_id) FROM tbl_services WHERE hotel_id='$hotel_id'");
	$data = $fetch_row->fetch_array();

	return $data[0];
}

function totalHotel(){
	global $mysqli_connect;
	$hotel_id = $_SESSION['hotel_id'];
	$fetch_row = $mysqli_connect->query("SELECT count(hotel_id) FROM tbl_hotels");
	$data = $fetch_row->fetch_array();

	return $data[0];
}

function totalUser(){
	global $mysqli_connect;
	$hotel_id = $_SESSION['hotel_id'];
	$fetch_row = $mysqli_connect->query("SELECT count(user_id) FROM tbl_users WHERE user_type!='C' OR user_type!='S'");
	$data = $fetch_row->fetch_array();

	return $data[0];
}

function totalMobileUser(){
	global $mysqli_connect;
	$hotel_id = $_SESSION['hotel_id'];
	$fetch_row = $mysqli_connect->query("SELECT count(user_id) FROM tbl_users WHERE user_type='C'");
	$data = $fetch_row->fetch_array();

	return $data[0];
}

function occupiedRoom(){
	global $mysqli_connect;
	$hotel_id = $_SESSION['hotel_id'];
	$fetch_row = $mysqli_connect->query("SELECT count(room_id) FROM tbl_rooms WHERE hotel_id='$hotel_id' AND status='1'");
	$data = $fetch_row->fetch_array();

	return $data[0];
}

function vacantRoom(){
	global $mysqli_connect;
	$hotel_id = $_SESSION['hotel_id'];
	$fetch_row = $mysqli_connect->query("SELECT count(room_id) FROM tbl_rooms WHERE hotel_id='$hotel_id' AND status!='1'");
	$data = $fetch_row->fetch_array();

	return $data[0];
}

function expectedArrival(){
	global $mysqli_connect;
	$hotel_id = $_SESSION['hotel_id'];
	$date = getCurrentDate();
	
	$fetch_row = $mysqli_connect->query("SELECT count(reservation_id) FROM tbl_reservation WHERE hotel_id='$hotel_id' AND status='A' AND start_date <= '$date'");
	$data = $fetch_row->fetch_array();

	return $data[0];
}

function server_url(){
	
	return "https://gecmath.com/kwarto-app/";
	//return "http://192.168.43.41/kwarto-app-web/kwarto-app/";
}

function expectedDeparture(){
	global $mysqli_connect;
	$hotel_id = $_SESSION['hotel_id'];
	$date = getCurrentDate();
	
	$fetch_row = $mysqli_connect->query("SELECT count(reservation_id) FROM tbl_reservation WHERE hotel_id='$hotel_id' AND status='I' AND end_date <= '$date'");
	$data = $fetch_row->fetch_array();

	return $data[0];
}

function totalReserved(){
	global $mysqli_connect;
	$hotel_id = $_SESSION['hotel_id'];
	$date = getCurrentDate();
	
	$fetch_row = $mysqli_connect->query("SELECT count(reservation_id) FROM tbl_reservation WHERE hotel_id='$hotel_id' AND (status='I' OR status ='A') AND end_date <= '$date'");
	$data = $fetch_row->fetch_array();

	return $data[0];
}

function getRefNum($id,$type){
	global $mysqli_connect;
	
	
    if($type == "H"){
        $fetch_row = $mysqli_connect->query("SELECT ref_number FROM tbl_reservation WHERE reservation_id='$id'");
    }else{
		$fetch_row = $mysqli_connect->query("SELECT ref_number FROM tbl_reservation_details WHERE rsd_id='$id'");
    }
	
	$data = $fetch_row->fetch_array();

	return $data[0];
}

function daysDifference($endDate, $beginDate){

	// if($beginDate == "" || $beginDate == "0000-00-00" || $beginDate == NULL){ $beginDate = ""; }

   $date_parts1 = explode("-", $beginDate);
   $date_parts2 = explode("-", $endDate);
   $start_date = gregoriantojd($date_parts1[1], $date_parts1[2], $date_parts1[0]);
   $end_date = gregoriantojd($date_parts2[1], $date_parts2[2], $date_parts2[0]);
   $diff = abs($end_date - $start_date);
   //$years = floor($diff / 365.25);
   return $diff;
}

function get_time_ago($datetime, $full = false) {
	$date = getCurrentDate();
    $now = new DateTime($date);
    $ago = new DateTime($datetime);
    $diff = $now->diff($ago);

    $diff->w = floor($diff->d / 7);
    $diff->d -= $diff->w * 7;

    $string = array(
        'y' => 'year',
        'm' => 'month',
        'w' => 'week',
        'd' => 'day',
        'h' => 'hour',
        'i' => 'minute',
        's' => 'second',
    );
    foreach ($string as $k => &$v) {
        if ($diff->$k) {
            $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
        } else {
            unset($string[$k]);
        }
    }

    if (!$full) $string = array_slice($string, 0, 1);
    return $string ? implode(', ', $string) . ' ago' : 'just now';
}
?>