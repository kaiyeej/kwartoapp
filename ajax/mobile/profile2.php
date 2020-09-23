<?php
header("Access-Control-Allow-Origin: *");
require_once '../../core/config.php';
$user_id = $_POST['user_id'];

$user_id = $_POST['user_id'];
$id = $_POST['id'];

if($id == "all"){
    $query = "";
}else{
    $query = "AND id ='$id'";
}

$fetchData = $mysqli_connect->query("SELECT * FROM tbl_users WHERE user_id='$user_id'");
$row = $fetchData->fetch_array();

?>
<div class="container-fluid">
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header p-2">
            <ul class="nav nav-pills">
              <li class="nav-item"><a class="nav-link active" href="#timeline" data-toggle="tab">Notifications</a></li>
            </ul>
          </div><!-- /.card-header -->
          <div class="card-body">
            <div class="tab-content">
              <!-- /.tab-pane -->
              <div class="tab-pane active" id="timeline">
            <?php
                $fetchNotif = $mysqli_connect->query("SELECT * FROM tbl_notifications WHERE user_id='$user_id' $query ORDER BY date_added ASC");
                $counter = 0;
                while($notifRow = $fetchNotif->fetch_array()){
                    $counter += 1;

                    $mysqli_connect->query("UPDATE tbl_notifications SET status='1' WHERE id='$notifRow[0]'");
            ?>
                <!-- The timeline -->
                <div class="timeline timeline-inverse">
                  <!-- timeline item -->
                  <div>
                    <i class="fas fa-bell bg-<?= $notifRow['type'] ?>"></i>

                    <div class="timeline-item">
                      <h3 class="timeline-header"><b><?= getHotel($notifRow['hotel_id']) ?></b></h3>
                      <div class="timeline-body">
                        <?= $notifRow['message']; ?>
                      </div>
                      <hr style="margin-top: 0rem;margin-bottom: 0rem;">
                      <div class="timeline-header"><span class="time"  style="color: #9E9E9E;font-size: 12px;float: right;"><i class="far fa-clock"></i> <?= get_time_ago(($notifRow['date_added'])); ?></span><br></div>
                    </div>
                  </div>
                </div>
            <?php }

                if($counter <= 0){ ?>
                <div>
                  <!-- timeline item -->
                  <center><h1 style="color: #9E9E9E;">! No details found.</h1></center>
                </div>
            <?php }
            ?>

              <!-- /.tab-pane -->

            </div>
            <!-- /.tab-content -->
          </div><!-- /.card-body -->
        </div>
        <!-- /.nav-tabs-custom -->
      </div>
      <!-- /.col -->
    </div>
    <!-- /.row -->
  </div><!-- /.container-fluid -->