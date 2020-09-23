<?php
header("Access-Control-Allow-Origin: *");
require_once '../../core/config.php';
$user_id = $_POST['user_id'];

$date = getCurrentDate();

$fetchCount = $mysqli_connect->query("SELECT count(id) FROM tbl_notifications WHERE status='0' AND user_id='$user_id'");
$count = $fetchCount->fetch_array();

$fetchData = $mysqli_connect->query("SELECT * FROM tbl_notifications WHERE status='0' AND user_id='$user_id'");
$row = $fetchData->fetch_array();

?>
<!-- Notifications Dropdown Menu -->
<li class="nav-item dropdown">
    <a class="nav-link" data-toggle="dropdown" href="#">
      <i class="far fa-bell"></i>
      <span class="badge <?php if($count[0] > 0){ ?>badge-warning<?php } ?> navbar-badge"><?php if($count[0] > 0){ echo $count[0]; } ?></span>
    </a>
    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
    <?php if($count[0] > 0){ ?>
      <span class="dropdown-item dropdown-header"><?= $count[0]; ?> Notification<?php if($count[0] > 1){ echo "s"; } ?></span>
      <div class="dropdown-divider"></div>
    <?php } ?>
    <?php
      if($count[0] > 0){
    ?>
      <a href="notifications.html?id=<?= $row[0] ?>" class="dropdown-item">
        <i class="fas fa-bell mr-2"></i> <?= getHotel($row['hotel_id']); ?>
        <span class="float-right text-muted text-sm"><?= get_time_ago(($row['date_added'])); ?></span>
      </a>
    <?php }else{ ?>
      <a href="#" class="dropdown-item" style="color:#9e9e9e;">
        ! No notification found.
      </a>
    <?php } ?>
      <div class="dropdown-divider"></div>
      <a href="notifications.html?id=all" class="dropdown-item dropdown-footer">See All Notifications</a>
    </div>
  </li>

<!-- CLOSE RESERVATION BASED DATE -->
<?php
$fetchRS = $mysqli_connect->query("SELECT ref_number FROM tbl_reservation WHERE customer_id='$user_id' AND status='S' AND start_date < '$date' AND reservation_type='M'");
while($rowRS = $fetchRS->fetch_array()){
  $mysqli_connect->query("UPDATE tbl_reservation SET status='NA' WHERE customer_id='$user_id' AND ref_number='$rowRS[0]'");
}


?>