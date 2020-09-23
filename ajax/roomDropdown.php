<?php
require_once '../core/config.php';
$type_id = $_POST['type_id'];
$hotel_id = $_SESSION['hotel_id'];
$start_date = $_POST['start_date'];
$end_date = $_POST['end_date'];
?>
<option value="">Please Select:</option>
<?php
    $fetchRoom = $mysqli_connect->query("SELECT * FROM tbl_rooms WHERE hotel_id='$hotel_id' AND type_id='$type_id' ORDER by room_name ASC");
    while($roomRow = $fetchRoom->fetch_array()){
        $room_status = roomStatus($roomRow['room_id'],$start_date,$end_date);

        if($room_status <= 0){ ?>
?>
        <option value="<?= $roomRow['room_id'] ?>"><?= $roomRow['room_name'] ?></option>
<?php   }
    } ?>