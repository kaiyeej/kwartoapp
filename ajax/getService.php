<?php
require_once '../core/config.php';
$service_type = $_POST['service_type'];
$hotel_id = $_SESSION['hotel_id']; ?>
 <?php
        if($service_type == "R"){ ?>
            <label>Room:</label>
            <select id="service_id" name="service_id" class="form-control" required>
            <option value="">Please Select:</option>
            <?php
                $fetchRoom2 = $mysqli_connect->query("SELECT * FROM tbl_rooms WHERE hotel_id='$hotel_id' ORDER by room_name ASC");
                while($rumRow = $fetchRoom2->fetch_array()){ ?>
                    <option value="<?= $rumRow['room_id'] ?>"><?= $rumRow['room_name']." (".getRoomType($rumRow['type_id']).")" ?></option>
            <?php } ?>
            </select>
    <?php }else{ ?>
            <label>Service:</label>
            <select id="service_id" name="service_id" class="form-control" required>
            <option value="">Please Select:</option>
            <?php
                $fetchService2 = $mysqli_connect->query("SELECT * FROM tbl_services WHERE hotel_id='$hotel_id' ORDER by service ASC");
                while($serRow = $fetchService2->fetch_array()){ ?>
                    <option value="<?= $serRow['service_id'] ?>"><?= $serRow['service'] ?></option>
            <?php } ?>
            </select>
    <?php } ?>
