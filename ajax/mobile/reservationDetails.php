<?php
header("Access-Control-Allow-Origin: *");
require_once '../../core/config.php';
$reservation_id = $_POST['reservation_id'];

$fetchData = $mysqli_connect->query("SELECT * FROM tbl_reservation WHERE reservation_id='$reservation_id'");
$row = $fetchData->fetch_array();
$days = daysDifference($row["end_date"], $row["start_date"]);
?>
    <div class="card">
        <div class="card-body box-profile">
            <p class="text-muted text-right"><strong>
            <?php
                if($row['status'] == "P"){
                    echo "<strong><i>Pending</i></strong>";
                }else if($row['status'] == "F"){
                    echo "<strong>Finished</strong>";
                }else if($row['status'] == "I"){
                    echo "<strong style='color: #4CAF50;'>Checked-in</strong>";
                }else if($row['status'] == "A"){
                    echo "<strong style='color: #607D8B;'>Approved</strong>";
                }else{
                    echo "<strong style='color: #F44336;'>Cancel</strong>";
                }
            ?>
            </strong><br>
            <h3 class="profile-username text-left"><?= $row['ref_number'] ?></h3>
            <p class="text-muted text-left"><strong><?= getHotel($row['hotel_id']); ?></strong><br>
            Date: <?= date('F d, Y',strtotime( $row["start_date"]))." - ".date('F d, Y',strtotime( $row["end_date"])); ?><br>
            Duartion: <?php if($days <= 1){ echo $days." night"; }else{ echo $days." nights"; } ?></p>
          <?php
                $fetchDetails = $mysqli_connect->query("SELECT * FROM tbl_reservation_details WHERE ref_number='$row[ref_number]'");
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
        </div>
    </div>

