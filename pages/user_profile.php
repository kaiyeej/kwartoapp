<?php
$user_id = $_SESSION['user_id'];
$fetchData = $mysqli_connect->query("SELECT * FROM tbl_users WHERE user_id='$user_id'");
$row = $fetchData->fetch_array();

?>
<div class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-8">
          <div class="card">
            <div class="card-header card-header-info">
              <h4 class="card-title">User Profile</h4>
              <p class="card-category">Manage your profile</p>
            </div>
            <div class="card-body">
              <form id="frm_user_profile" action="" method="POST">
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <input type="text" name="name" id="name" value="<?= $row['name']; ?>" class="form-control">
                    <div class="form-group">
                      <input type="text" value="<?= $row['username']; ?>" id="username" name="username" class="form-control" required>
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                    Contact #
                      <input type="text" value="<?= $row['contact_number']; ?>" id="contact_number" name="contact_number" class="form-control">
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                    Email
                      <input type="email" value="<?= $row['email']; ?>" id="email" name="email" class="form-control">
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-12">
                    <div class="form-group">
                      <div class="form-group">
                      Address
                        <textarea id="address" name="address" class="form-control" rows="5"><?= $row['address']; ?></textarea>
                      </div>
                    </div>
                  </div>
                </div>
                <button type="submit" id="btn_save" class="btn btn-primary pull-right">Update Profile</button>
              </form>
                <button type="buuton" title="Update Password" onclick="viewModal()" class="btn btn-success pull-right"><span class="material-icons">lock</span> Password</button>
            </div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="card card-profile">
            <div class="card-body">
              <h4 class="card-title"><?= $row['name']; ?></h4>
              <h6 class="card-category text-gray"><?php if(empty($row['hotel_id']) OR $row['hotel_id'] == 0){ echo "ADMIN"; }else{ echo getHotel($row['hotel_id']); } ?></h6>
              <p class="card-description">
                <?= getHotelDesc($row['hotel_id']) ?>
              </p>
            </div>
          </div>
        </div>
      </div>
    </div>
</div>
<?php include "modals/modal_user_profile.php"; ?>
<script>
  $("#frm_user_profile").submit(function(e){
    e.preventDefault();
    $("#btn_save").prop("disabled",true);
    $("#btn_save").html("<span class='fa fa-spin fa-spinner'></span> processing ...");
    
    var username = $("#username").val();
    $.ajax({
      type: "POST",
      url: "ajax/manageProfile.php",
      data: $('#frm_user_profile').serialize(),
      success: function(data){
        if(data == 1){
          alertNotify('All Good!',"Successfully updated entry!","success");
        }else if(data == 2){
          alertNotify('Cannot Proceed!',"Username "+username+" already exist!","warning");
        }else{
          failed_query('Manage User Profile');
        }

        $("#btn_save").html("Update Profile");
        $("#btn_save").prop("disabled",false);
      }
      
    });
    
  });

  function viewModal(){
    $("#modalUserProfile").modal("show");
  }

  function updatePassword(){
    $("#btn_pass").prop("disabled",true);
    $("#btn_pass").html("<span class='fa fa-spin fa-spinner'></span> processing ...");

    var old_password = $("#old_password").val();
    var new_password = $("#new_password").val();
    var confirm_password = $("#confirm_password").val();

    if(old_password == "" || new_password == "" || confirm_password == ""){
      alertNotify('Cannot proceed!',"Provide all required fields!","warning");

      $("#btn_pass").prop("disabled",false);
      $("#btn_pass").html("<i class='material-icons'>check</i> Save Entry");
    }else if(new_password != confirm_password){
      alertNotify('Cannot proceed!',"Password does not match.","warning");

      $("#btn_pass").prop("disabled",false);
      $("#btn_pass").html("<i class='material-icons'>check</i> Save Entry");
    }else{
        $.ajax({
          type: "POST",
          url: "ajax/updatePassword.php",
          data: {
            old_password:old_password,
            new_password:new_password,
            confirm_password:confirm_password
          },
          success: function(data){
            if(data == 2){
              alertNotify('Cannot proceed!',"Old password does not match.","warning");
            }else if(data == 1){
              success_update();
              $("#modalUserProfile").modal("hide");
              $("#old_password").val("");
              $("#new_password").val("");
              $("#confirm_password").val("");
            }else{
              failed_query();
            }
            $("#btn_pass").prop("disabled",false);
            $("#btn_pass").html("<i class='material-icons'>check</i> Save Entry");
          }
        });
    }
  }
</script>