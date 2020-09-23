<?php
require_once '../core/config.php';

if(isset($_POST['id'])){
    $id = $mysqli_connect->real_escape_string($_POST['id']);
    $hotel_id = $_SESSION['hotel_id'];
    
    $fetchData = $mysqli_connect->query("SELECT * FROM tbl_reservation WHERE reservation_id='$id' AND hotel_id='$hotel_id'");
    $row = $fetchData->fetch_array();
    $customer_id = $row['customer_id'];

    if($row['status'] == "P"){
        $status = "A";
        $remarks = "from Pending to Approved";
        $notif = 1;
    }else if($row['status'] == "A"){
        $status = "I";
        $remarks = "from Approved to Check-in";
        $notif = 0;
    }else if($row['status'] == "I"){
        $status = "F";
        $remarks = "from Check-in to Finished";
        $message = "Booking Ref # ".$row['ref_number']." approved";
        $type = "info";
        $notif = 0;
    }

    $fetchRoomCount = $mysqli_connect->query("SELECT count(rsd_id) FROM `tbl_reservation_details` WHERE ref_number='$row[ref_number]' AND room_id!='0' AND type='R'");
    $checkRoom = $fetchRoomCount->fetch_array();
    if($status == "I" AND $checkRoom[0] <= 0){
        echo 2;
    }else{
        $query = $mysqli_connect->query("UPDATE tbl_reservation SET status='$status' WHERE reservation_id='$id' AND hotel_id='$hotel_id'");
        if($query){
            
            if($status == "I" OR $status == "F"){
                $fetchRoom = $mysqli_connect->query("SELECT * FROM tbl_reservation_details WHERE ref_number='$row[ref_number]'");
                while($roomRow = $fetchRoom->fetch_array()){
                    if($status == "F"){
                        $mysqli_connect->query("UPDATE tbl_rooms SET status='0' WHERE room_id='$roomRow[room_id]' AND hotel_id='$hotel_id'");
                    }else{
                        $mysqli_connect->query("UPDATE tbl_rooms SET status='1' WHERE room_id='$roomRow[room_id]' AND hotel_id='$hotel_id'");
                    }
                }
            }

            $mysqli_connect->query("UPDATE tbl_reservation_details SET status='$status' WHERE ref_number='$row[ref_number]'");
    
            echo 1;
            if($notif == 1 AND $row['reservation_type'] == "M"){
                insertNotif($customer_id, "Booking status for Ref # ".$row['ref_number']." approved", "info",$hotel_id);
            }
    
            insertLogs($_SESSION['user_id'], "Update Booking Status $remarks: ".$row['ref_number']);
        }else{
            echo 0;
        }
    }
	
}

?>