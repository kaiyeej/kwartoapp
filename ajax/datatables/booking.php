<?php
require_once '../../core/config.php';
$user_type = $_SESSION['user_type'];
$hotel_id = $_SESSION['hotel_id'];
$type = $_POST['status_type'];
$date = getCurrentDate();
if($type == "all"){
    $query = "";
}else{
    if($type == "AT"){
        $query = "AND status='A' AND start_date <= '$date'";
    }else if($type == "DT"){
        $query = "AND status='I' AND end_date <= '$date'";
    }else{
        $query = "AND status='$type'";
    }
}


$fetchData = $mysqli_connect->query("SELECT * FROM tbl_reservation WHERE hotel_id='$hotel_id' $query ORDER by reservation_id DESsC") or die(mysqli_error());

$response['data'] = array();
$count = 1;
while($row = $fetchData->fetch_array() ){
	$list = array();
    
    if($row['status'] == "P"){
        $status = "<span style='color:#ffc107;'>Pending</span>";
        $title = "Approve Reservation";
        $display = "";
        $cancel = "";
        $print = "display:none;";
    }else if($row['status'] == "A"){
        $status = "<span style='color:#607d8b;'>Approved</span>";
        $title = "Update status to check-in";
        $display = "";
        $cancel = "";
        $print = "display:none;";
    }else if($row['status'] == "C"){
        $status = "<span style='color:#f44336;'>CANCEL</span>";
        $display = "display:none;";
        $title = "";
        $cancel = "display:none;";
        $print = "display:none;";
    }else if($row['status'] == "I"){
        $status = "<span style='color:#2196f3;'>CHECKED-IN</span>";
        $title = "Update status to check-out";
        $display = "";
        $print = "display:none;";
        $cancel = "display:none;";
    }else{
        $status = "<strong style='color:green;'>CHECKED-OUT</strong>";
        $display = "display:none;";
        $cancel = "display:none;";
        $title = "";
        $print = "";
    }

    $fetchDetails = $mysqli_connect->query("SELECT * FROM tbl_reservation_details WHERE ref_number='$row[ref_number]'");
    $service_count = 0;
    $room_count = 0;
    $service_ = "";
    $room_ = "";
    while($rowR = $fetchDetails->fetch_array()){
        if($rowR['type'] == "S"){
            $service_count += 1;
        }

        if($rowR['type'] == "R"){
            $room_count += 1;
        }

        $service_ .= getService($rowR['service_id']).", ";
        $room_ .= getRoom($rowR['room_id']).", ";
    }

    if($service_count > 0){
        $service = "Service: ".substr($service_, 0,-2);
    }else{
        $service = "";
    }

    if($room_count > 0){
        $room = "Room: ".substr($room_, 0,-2);
    }else{
        $room = "";
    }

    $remarks = $room."<br>".$service;
    
    $list['id'] = $row['reservation_id'];
    $list['count'] = $count++;
    $list['reservation_number'] = $row['ref_number'];
    $list['button'] = "<center><button type='button' onclick='getEntryDetails($row[reservation_id])' rel='tooltip' title='View Booking' class='btn btn-primary btn-round'><i class='material-icons'>list</i></button><button type='button' style='$display' onclick='updateStatus($row[reservation_id])' rel='tooltip' title='$title' class='btn btn-success btn-round'><i class='material-icons'>check</i></button><button style='$cancel' onclick='cancelBooking($row[reservation_id])' type='button' rel='tooltip' title='Cancel' class='btn btn-danger btn-round' id='btn_cancel".$row['reservation_id']."'><i class='material-icons'>close</i></button><button onclick=window.location='index.php?page=print-invoice&ref=$row[ref_number]' style='$print' type='button' rel='tooltip' title='Print Invoice' class='btn btn-default btn-round'><i class='material-icons'>local_printshop</i></button></center>";
    $list['customer'] = ($row['customer_id'] != 0?getUser($row['customer_id']):$row['walk_in']);
    $list['date'] = date('F d, Y',strtotime( $row["start_date"]))."-".date('F d, Y',strtotime( $row["end_date"]));
    $list['status'] = $status;
    $list['remarks'] = $remarks;

	array_push($response['data'], $list);
}

echo json_encode($response);

?>