<?php
header("Access-Control-Allow-Origin: *");
require_once '../../core/config.php';
$user_id = $_POST['user_id'];

$fetchData = $mysqli_connect->query("SELECT * FROM tbl_reservation WHERE customer_id='$user_id' AND  (status='S' OR status='NA')");
$counter = 0;
while($row = $fetchData->fetch_array()){
    $days = daysDifference($row["end_date"], $row["start_date"]);
    $counter += 1;
?>
    <div class="card">
        <div class="card-body box-profile">
            <p class="text-muted text-right"><span class="ion-ios-trash-outline" style="font-size: 26px;color: red;" onclick="deleteReservation(<?= $row['reservation_id']; ?>)"></span></p>
            <?php if($row['status'] == "NA"){ ?>
            <h3 class="profile-username text-right"><strong style="color: #FF5722;">Not Available</strong></h3>
            <?php } ?>
            <h3 class="profile-username text-left"><?= $row['ref_number'] ?></h3>
            <p class="text-muted text-left"><strong><?= getHotel($row['hotel_id']); ?></strong><br>
            Date: <?= date('F d, Y',strtotime( $row["start_date"]))." - ".date('F d, Y',strtotime( $row["end_date"])); ?><br>
            Duartion: <?php if($days <= 1){ echo $days." night"; }else{ echo $days." nights"; } ?></p>
          <?php
                $fetchDetails = $mysqli_connect->query("SELECT * FROM tbl_reservation_details WHERE ref_number='$row[ref_number]' AND status='S'");
                $total = 0;
                while($dRow = $fetchDetails->fetch_array()){
                    $total += $dRow['amount'];
                    if($dRow['type'] == "R"){
                        $type = "Room";
                        $remarks = getRoomType($dRow['type_id']);
                    }else{
                        $type = "Service";
                        $remarks = getService($dRow['service_id']);
                        }
                ?>
                    <ul class="list-group list-group-unbordered mb-3">
                        <li class="list-group-item" style="padding: 5px;">
                            <a class="float-right" onclick="deleteDetails(<?= $dRow['rsd_id']; ?>)"><span class="ion-ios-close-outline" style="color:#f57f17;font-size: 20px;"></span></a>
                        </li>
                        <li class="list-group-item">
                        <?=  $type; ?> Type:<a class="float-right"><?= $remarks; ?></a>
                        </li>
                        <li class="list-group-item">
                            Qty:<a class="float-right"><?= $dRow['qty']; ?></a>
                        </li>
                        <li class="list-group-item">
                        Amount <a class="float-right">&#8369;<?= number_format($dRow['amount'],2); ?></a>
                        </li>
                    </ul>

                    
        <?php } ?>
            <p class="text-muted text-right" style="font-size: 20px;">Total: <strong>&#8369;<?= number_format($total,2); ?></strong><br>
        <?php if($row['status'] != "NA"){ ?>
            <p class="text-muted text-center"><a href="#" onclick="reserveNow(<?= $row[0] ?>,<?= $user_id ?>)" class="btn btn-outline-primary btn-block"><b>Book now</b></a></p>
        <?php } ?>
        </div>
    </div>

<?php }

    if($counter <= 0){ ?>
    <div class="rooms_item" style="border: 1px solid #e0e0e0;padding: 10px;box-shadow: 4px 4px #EEEEEE;padding: 52px;">
        <center><span style="color: #B0BEC5;font-size: 20px;">! No details found.</span></center>
    </div>
<?php } ?>

