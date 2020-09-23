<?php
header("Access-Control-Allow-Origin: *");
require_once '../../core/config.php';

$start_date = $_POST['start_date'];
$end_date = $_POST['end_date'];
$capacity = $_POST['capacity'];
$hotel_search = $_POST['hotel_search'];

$user_id = $_POST['user_id'];

$countPending = $mysqli_connect->query("SELECT * FROM tbl_reservation WHERE customer_id='$user_id' AND status='S' AND reservation_type='M'");
if(mysqli_num_rows($countPending) > 0){
  $penHotel = $countPending->fetch_array();
  $query = "AND hotel_id='$penHotel[hotel_id]'";
}else{
  $query = "";
}

    $fetchRoom = $mysqli_connect->query("SELECT * FROM tbl_hotels WHERE hotel_name like '%$hotel_search%' $query");
    while($row = $fetchRoom->fetch_array()){
        $total_room = availableRoom($capacity,$start_date,$end_date,$row['hotel_id']);
        
       if($total_room > 0){
            if(empty($row['hotel_img'])){
                $img = "images/no_img.jpg";
            }else{
                $img = server_url()."/assets/hotel_img/".$row['hotel_img'];
            }
?>
        <!-- Room -->
        <div class="card">
            <div class="card-body box-profile">
                <div class="text-center">
                  <img class="img-fluid img-square"
                       src="<?= $img; ?>">
                </div>
                <h3 class="profile-username text-center"><?= $row['hotel_name']; ?></h3>
                <p class="text-muted text-center" style="font-size: 11px;"><span class="material-icons" style="font-size: 12px;">email </span> <?= $row['hotel_email'] ?>  |  <span class="material-icons" style="font-size: 12px;">phone_android</span> <?= $row['hotel_contact_number'] ?>  |  <span class="material-icons" style="font-size: 12px;">location_on</span> <?= $row['hotel_address'] ?></p>
    
                <ul class="list-group list-group-unbordered mb-3">
                    <li class="list-group-item">
                    <b>Room available</b> <a class="float-right"><?= $total_room; ?></a>
                    </li>
                    <li class="list-group-item">
                    <b>Description</b> <a class="float-right" style="word-break:break-all;"><?= $row['hotel_description']; ?></a>
                    </li>
                </ul>
                <div class="text-center">
                    <button onclick="accessHotel('<?= $row['hotel_name']; ?>',<?= $row['hotel_id'] ?>)" id="access_<?= $row['hotel_id'] ?>" class="btn btn-outline-primary" style="width:50%;"><b>Visit Hotel</b></button>
                </div>
            </div>
        </div>
<?php 
        }
    } ?>

