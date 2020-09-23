<?php
header("Access-Control-Allow-Origin: *");
require_once '../../core/config.php';
$user_id = $_POST['user_id'];

$countPending = $mysqli_connect->query("SELECT * FROM tbl_reservation WHERE customer_id='$user_id' AND status='S' AND reservation_type='M'");
if(mysqli_num_rows($countPending) > 0){
  $penHotel = $countPending->fetch_array();
  $query = "WHERE hotel_id='$penHotel[hotel_id]'";
}else{
  $query = "";
}

$fetchRoom = $mysqli_connect->query("SELECT * FROM tbl_hotels $query");
while($row = $fetchRoom->fetch_array()){
    if(empty($row['hotel_img'])){
        $img = "images/no_img.jpg";
    }else{
        $img = server_url()."/assets/hotel_img/".$row['hotel_img'];
    }
?>
    <!-- Default box -->
    <div class="card card-primary">
         <!-- Hotel -->
            <div class="card-body pt-0">
                <br>
                <div class="row">
                    <div class="col-5 text-center">
                      <img src="<?= $img; ?>" alt="" class="img-square img-fluid">
                    </div>
                    <div class="col-7">
                        <h2 class="lead"><b><?= $row['hotel_name']; ?></b></h2>
                        <ul class="ml-4 mb-0 fa-ul text-muted">
                        <li class="small"><span class="fa-li"><i class="fas fa-lg fa-building"></i></span> Address: <?= $row['hotel_address']; ?></li>
                        <li class="small"><span class="fa-li"><i class="fas fa-lg fa-phone"></i></span> Contact #: <?= $row['hotel_contact_number']; ?></li>
                        <li class="small"><span class="fa-li"><i class="fas fa-lg fa-envelope"></i></span> Email: <?= $row['hotel_email']; ?></li>
                        <li class="small" style="padding-top: 50px;"><button onclick="accessHotel('<?= $row['hotel_name']; ?>',<?= $row['hotel_id'] ?>)" id="access_<?= $row['hotel_id'] ?>" class="btn btn-block btn-outline-primary" style="width: 55%;"> View</button></li>
                        </ul>
                    </div>
                </div>
              </div>
              <div class="card-footer">
                <div class="text-center">
                
                </div>
              </div>
        </div>
        <br>
<?php } ?>