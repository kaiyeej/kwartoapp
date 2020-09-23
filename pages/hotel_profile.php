<?php

$hotel_id = $user_id = $_SESSION['hotel_id'];
$fetchData = $mysqli_connect->query("SELECT * FROM tbl_hotels WHERE hotel_id='$hotel_id'");
$row = $fetchData->fetch_array();

?>
<style>
    img{
        width:250px;
    }
</style>
<div class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-8">
          <div class="card">
            <div class="card-header card-header-info">
              <h4 class="card-title">Hotel Profile</h4>
              <p class="card-category">Manage hotel profile</p>
            </div>
            <div class="card-body">
              <form id="frm_hotel_profile" action="" method="POST">
                <div class="row">
                  <div class="col-md-12">
                    <div class="form-group">
                    Hotel
                      <input type="text" name="hotel_name" id="hotel_name" value="<?= $row['hotel_name']; ?>" class="form-control">
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                    Contact #
                      <input type="text" value="<?= $row['hotel_contact_number']; ?>" id="hotel_contact_number" name="hotel_contact_number" class="form-control">
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                    Email
                      <input type="email" value="<?= $row['hotel_email']; ?>" id="hotel_email" name="hotel_email" class="form-control">
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-12">
                    <div class="form-group">
                      <div class="form-group">
                      Address
                        <textarea id="hotel_address" name="hotel_address" class="form-control"><?= $row['hotel_address']; ?></textarea>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-12">
                    <div class="form-group">
                      <div class="form-group">
                      Description
                        <textarea id="hotel_description" name="hotel_description" class="form-control" rows="5"><?= $row['hotel_description']; ?></textarea>
                      </div>
                    </div>
                  </div>
                </div>
                <button type="submit" id="btn_save" class="btn btn-primary pull-right">Update Profile</button>
              </form>
            </div>
          </div>
        </div>
        
        <div class="col-md-4">
          <div class="card card-profile">
            <div class="fileinput fileinput-new text-center" data-provides="fileinput">
            <form id="frm_hotel_img" action="" method="POST">
                <div class="fileinput-new thumbnail img-raised">
                    <?php
                        if(!empty($row['hotel_img'])){
                            $img_src = $row['hotel_img'];
                        }else{
                            $img_src = "no_img.jpg";
                        }
                    ?>
                    <img src="assets/hotel_img/<?= $img_src; ?>" rel="nofollow" alt="...">
                </div>
                <div class="fileinput-preview fileinput-exists thumbnail img-raised"></div>
                <div>
                    <span class="btn btn-raised btn-round btn-rose btn-file">
                    <span class="fileinput-new">Select image</span>
                    <span class="fileinput-exists">Change</span>
                    <input type="file" id="file" name="file"/>
                    </span>
                        <a href="javascript:;" class="btn btn-danger btn-round fileinput-exists" data-dismiss="fileinput">
                        <i class="fa fa-times"></i> Remove</a>
                        <button type="submit" class="btn btn-primary btn-round fileinput-exists"><span class="fa fa-upload"></span> UPLOAD</button>
            </form>
            </div>
          </div>
        </div>
      </div>
    </div>
</div>
<script>
  $("#frm_hotel_profile").submit(function(e){
    e.preventDefault();
    $("#btn_save").prop("disabled",true);
    $("#btn_save").html("<span class='fa fa-spin fa-spinner'></span> processing ...");
    
    var username = $("#username").val();
    $.ajax({
      type: "POST",
      url: "ajax/manageHotelProfile.php",
      data: $('#frm_hotel_profile').serialize(),
      success: function(data){
        if(data == 1){
          alertNotify('All Good!',"Successfully updated entry!","success");
        }else if(data == 2){
          alertNotify('Cannot Proceed!',"Username "+username+" already exist!","warning");
        }else{
          failed_query('Manage User Profile');
          alert(data);
        }

        $("#btn_save").html("Update Profile");
        $("#btn_save").prop("disabled",false);
      }
      
    });
    
  });

  function viewModal(){
    $("#modalHotelLogo").modal("show");
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

$("#frm_hotel_img").submit(function(e){
    e.preventDefault();
    $.ajax({
		type: "POST",
        url: "ajax/uploadImg.php",
        data: new FormData(this),
        processData: false,
        contentType: false,
        success: function(data){
		    if(data == 1){
			    success_update();
			}else{
          failed_query("Upload Image");
          alert(data);
			}
		}
    });
});
</script>