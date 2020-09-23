<?php
header("Access-Control-Allow-Origin: *");
require_once '../../core/config.php';
$user_id = $_POST['user_id'];
$fetchData = $mysqli_connect->query("SELECT * FROM tbl_users WHERE user_id='$user_id'");
$row = $fetchData->fetch_array();

?>
<div class="container-fluid">
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header p-2">
            <ul class="nav nav-pills">
              <li class="nav-item"><a class="nav-link active" href="#settings" data-toggle="tab">Settings</a></li>
              <li class="nav-item"><a class="nav-link" href="#timeline" data-toggle="tab">Notifications</a></li>
            </ul>
          </div><!-- /.card-header -->
          <div class="card-body">
            <div class="tab-content">
              <div class="tab-pane active" id="settings">
                <form id="frm_profile" method="POST" action="">
                  <div class="form-group row">
                    <label for="inputName" class="col-sm-2 col-form-label">Name</label>
                    <div class="col-sm-10">
                      <input style="width:50%;" type="text" class="form-control" name="name" required value="<?= $row['name']; ?>">
                    </div>
                  </div>
                  <input type="hidden" name="user_id" value="<?= $row['user_id'] ?>">
                  <div class="form-group row">
                    <label for="inputEmail" class="col-sm-2 col-form-label">Email</label>
                    <div class="col-sm-10">
                      <input style="width:50%;" type="email" class="form-control" name="email" value="<?= $row['email']; ?>" required>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="inputName2" class="col-sm-2 col-form-label">Contact #</label>
                    <div class="col-sm-10">
                      <input style="width:50%;" type="text" class="form-control" name="contact_number" value="<?= $row['contact_number']; ?>" required>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="inputExperience" class="col-sm-2 col-form-label">Address</label>
                    <div class="col-sm-10">
                      <textarea style="width:50%;" class="form-control" name="address" required><?= $row['address']; ?></textarea>
                    </div>
                  </div>
                  <div class="form-group row">
                    <div class="col-sm-10">
                      <button style="width:70%;" type="submit" class="btn btn-info"><span class="ion-android-checkmark-circle"></span>  Update</button>
                    </div>
                  </div>
                </form>
              </div>
              <!-- /.tab-pane -->
              <div class="tab-pane" id="timeline">
            <?php
                $fetchNotif = $mysqli_connect->query("SELECT * FROM tbl_notifications WHERE user_id='$user_id' ORDER BY date_added ASC");
                $counter = 0;
                while($notifRow = $fetchNotif->fetch_array()){
                    $counter += 1;
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
<script>
    
$("#frm_profile").submit(function(e){
    e.preventDefault();
      $.ajax({
      type:"POST",
        url: server_url()+"ajax/mobile/updateProfile.php",
        data:$('#frm_profile').serialize(),
        success:function(data){
          if(data == 1){
              swal("Success!", "Successfully updated profile!", "success");
            }else{
              swal("Failed to execute query!", "Profile", "warning");
              alert(data);
            }
        }
      });
});
</script>