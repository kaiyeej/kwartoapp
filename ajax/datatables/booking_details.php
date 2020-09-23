<?php
require_once '../../core/config.php';
$hotel_id = $_SESSION['hotel_id'];
$ref_number = $_POST['ref_number'];

$fetchData = $mysqli_connect->query("SELECT * FROM tbl_reservation_details WHERE ref_number='$ref_number'") or die(mysqli_error());

$response['data'] = array();
$count = 1;
while($row = $fetchData->fetch_array() ){
    $list = array();
    
    $fetchHeader = $mysqli_connect->query("SELECT * FROM tbl_reservation WHERE ref_number='$ref_number'");
    $rowHead = $fetchHeader->fetch_array();
    
    if($row['type'] == "R"){
        $type = "ROOM";
        if(($rowHead['status'] == "P" OR $rowHead['status'] == "A") AND $rowHead['reservation_type'] == "M"){

            $fetchRoom2 = $mysqli_connect->query("SELECT * FROM tbl_rooms WHERE hotel_id='$hotel_id' AND type_id='$row[type_id]' ORDER by room_name ASC");
           
            $room_dropdown = "";
            while($rumRow = $fetchRoom2->fetch_array()){
                $room_dropdown .= "<option value=".$rumRow['room_id'].">".$rumRow['room_name']." (".getRoomType($rumRow['type_id']).") </option>";
            }
            
            if($row['room_id'] == 0){
                $room_dropdown_selected = "<option value='-1' selected>---</option>";
            }else{
                $room_dropdown_selected = "";
            }

            $service_room = '<div class="input-group mb-3">
            <select id="assign_room" name="assign_room" class="form-control">'.$room_dropdown_selected.$room_dropdown.'</select>
            <div style="background: #009688;" class="input-group-append">
              <button type="button" id="btn_assign'.$row[0].'" onclick="assignRoom('.$row[0].')" class="input-group-text"><span class="material-icons">add_circle_outline</span></button>
            </div>
          </div>';
        }else{
            $service_room = getRoom($row['room_id']);
        }

        $amount = getRoomPrice($row['room_id'])*$row['qty'];
    }else{
        $type = "Service";
        $service_room = getService($row['service_id']);
        $amount = getServicePrice($row['service_id'])*$row['qty'];
    }

    if($rowHead['status'] == "F" OR $rowHead['status'] == "C"){
        $btn = "";
    }else{
        $btn = "<center><button type='button' rel='tooltip' title='Remove' onclick='deleteDetails($row[rsd_id])' class='btn btn-danger btn-link btn-sm'><i class='material-icons'>delete_outline</i></button></center>";
    }
    
    $list['id'] = $row['rsd_id'];
    $list['count'] = $count++;
    $list['reservation_number'] = $row['ref_number'];
    $list['button'] = $btn;
    $list['type'] = $type;
    $list['service_room'] = $service_room;
    $list['amount'] = number_format($amount,2);
    $list['qty'] = $row['qty'];

	array_push($response['data'], $list);
}

echo json_encode($response);

?>