<?php
header("Access-Control-Allow-Origin: *");
require_once '../../core/config.php';

$hotel_id = $_POST['hotel_id'];
$fetchData = $mysqli_connect->query("SELECT * FROM tbl_hotels WHERE hotel_id='$hotel_id'");
$row = $fetchData->fetch_array();
?>
<center>
    <h1 style="color: #607D8B;"><?= $row['hotel_name'] ?></h1>
    <h5><?= $row['hotel_description'] ?></h5>
    <p style="font-size: 10px;"><span class="material-icons" style="font-size: 12px;">email </span> <?= $row['hotel_email'] ?>  |  <span class="material-icons" style="font-size: 12px;">phone_android</span> <?= $row['hotel_contact_number'] ?>  |  <span class="material-icons" style="font-size: 12px;">location_on</span> <?= $row['hotel_address'] ?> </p>
</center>
<hr>
<!-- Blog Posts -->
<div class="card card-primary">
    <div class="row">
        <div class="col-xl-6">
	        <div class="card-body pt-0">
                <div class="blog_post_image" onclick="window.location='hotel_rooms.html?id=<?= $hotel_id; ?>'">
                    <center><span class="material-icons" style="font-size:90px;color: #607d8b;">room</span><p style='font-size: 20px;'>(<?= total_room($hotel_id) ?>) <?php if(total_room($hotel_id) > 1){ echo "Rooms"; }else{ echo "Room"; } ?></p></center>
                </div>
            </div>
        </div>
        <div class="col-xl-6">
	        <div class="card-body pt-0">
                <div class="blog_post_image" onclick="window.location='hotel_services.html?id=<?= $hotel_id; ?>'">
                    <center><span class="material-icons" style="font-size:90px;color: #607d8b;">room_service </span><p style='font-size: 20px;'>(<?= total_service($hotel_id) ?>) <?php if(total_service($hotel_id) > 1){ echo "Services"; }else{ echo "Service"; } ?></p></center>
                </div>
            </div>
        </div>
    </div>
</div>