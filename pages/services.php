<div class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header card-header-info">
            <h4 class="card-title">Services</h4>
            <p class="card-category"> Manage service entries</p>
          </div>
          <div class="card-body">
            <div class="col-md-12">
              <button class="btn btn-danger btn-sm pull-right" id="btn_delete" onclick="deleteEntry()"><span class="material-icons">delete_outline</span> Delete</button>
              <button type="button" class="btn btn-success btn-sm pull-right" onclick="modalManage('add')"><span class="material-icons">add_circle_outline</span> Add</button>
            </div>
            <div class="table-responsive">
              <div class="col-lg-12" style="background-color:transparent;margin-top:10px;">
                  <table id="dt_services" class="table table-striped table-bordered" style="width:100%">
                    <thead style="padding: 10px;background-color: #607D8B;color: #fff;">
                        <tr>
                            <th><strong><input type='checkbox' onchange="checkAll(this,'service_id')"></strong></th>
                            <th><strong></strong></th>
                            <th><strong>#</strong></th>
                            <th><strong>Service</strong></th>
                          <?php if($_SESSION['user_type'] == "S"){ ?>
                            <th><strong>Hotel</strong></th>
                          <?php } ?>
                            <th><strong>Description</strong></th>
                            <th><strong>Encoded by</strong></th>
                            <th style="width:65px;"><strong>Image</strong></th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- MODAL START -->
<?php include 'pages/modals/modal_manage_service.php'; ?>
<?php include 'pages/modals/modal_img_service.php'; ?>
<!-- MODAL END -->
<script>
$(document).ready(function() {
  getServices();

  var user_type = "<?= $_SESSION['user_type'] ?>";
  if(user_type == "A"){
    $("#div_hotel").hide();
    $("#hotel_id").html("<option value='<?= $_SESSION['hotel_id']; ?>'><?= getHotel($_SESSION['hotel_id']) ?></option>");
  }else{
    $("#div_hotel").show();
  }
});

function showModalUpdateImg(service_d){
  $("#modalServiceLogo").modal("show");
  $("#service_id_img").val(service_d);
  $("#div_logo").html("<img src='assets/room_img/no_img.jpg' rel='nofollow' alt='room'>");
  albumModal(service_d);
}

function removeIMG(id,service_d){
  $.ajax({
		type: "POST",
    url: "ajax/deleteImgService.php",
    data: {
      id:id
    },
    success: function(data){
      if(data == 1){
        success_delete();
        albumModal(service_d)
      }else{
        failed_query("Remove Image");
        alert(data);
      }
		}
  });
}

function albumModal(id){
  
  $.ajax({
		type: "POST",
    url: "ajax/serviceAlbum.php",
    data: {
      id:id
    },
    success: function(data){
      $("#div_imgs").html(data);
		}
  });
}

$("#frm_service_img").submit(function(e){
    e.preventDefault();
    var service_id = $("#service_id_img").val();
    $.ajax({
		type: "POST",
        url: "ajax/uploadImgService.php",
        data: new FormData(this),
        processData: false,
        contentType: false,
        success: function(data){
		    if(data == 1){
			    success_update();
          getServices();
          albumModal(service_id);
        }else{
          failed_query("Upload Image");
          alert(data);
        }
		}
    });
});

function modalManage(type){
  
  $("#modalManageService").modal("show");
  $("#type").val(type);
}

function getEntryDetails(id){

  $("#modalManageService").modal("show");
  var tb = "tbl_services";
  var keyword = "service_id";

  $.ajax({
    type:"POST",
    url:"ajax/getDetails.php",
    data:{
      id:id,
      tb:tb,
      keyword:keyword
    },
    success:function(data){
      var json = JSON.parse(data);
      $("#service_id").val(json.service_id);
      $("#service").val(json.service);
      $("#hotel_id").val(json.hotel_id);
      $("#service_description").val(json.service_description);
      $("#service_rate").val(json.service_rate);
      $("#type").val(type);
    }
  });
}

function deleteEntry(){
  var count_checked = $("input[class='service_id']:checked").length;
  var tb = "tbl_services";
  var keyword = "service_id";

  if(count_checked > 0){
      swal({
          title: "Are you sure?",
          text: "You will not be able to recover these entries!",
          type: "warning",
          showCancelButton: true,
          confirmButtonClass: "btn-danger",
          confirmButtonText: "Yes, delete it!",
          cancelButtonText: "No, cancel!",
          closeOnConfirm: false,
          closeOnCancel: false
      },
      function(isConfirm) {
          if (isConfirm) {
              var checkedValues = $("input[class='service_id']:checked").map(function() {
                  return this.value;
              }).get();

              $("#btn_delete").prop('disabled', true);
              $("#btn_delete").html("<span class='fa fa-spinner fa-spin' style='color:#fff;'></span> processing ...");

              $.ajax({
                  type:"POST",
                  url:"ajax/deleteBulkEntries.php",
                  data:{
                      id:checkedValues,
                      tb:tb,
                      keyword:keyword
                  },
                  success:function(data){
                      if(data == 1){
                          //alert('Successfully deleted entries.');
                          success_delete();
                          getServices();
                      }else{
                          //alert('Something is wrong. Failed to execute query. Please try again.');
                         // alert(data);
                          failed_query(data);
                      }

                      $("#btn_delete").prop('disabled', false);
                      $("#btn_delete").html("<span class='material-icons'>delete_outline</span> Delete");
                  }
              });
              
          } else {
              swal("Cancelled", "Entries are safe :)", "error");
          }
      });
  }else{
      swal("Cannot proceed!", "Please select entries to delete!", "warning");
  }
}

$("#frm_manage_services").submit(function(e){
  e.preventDefault();
  $("#btn_save").prop("disabled",true);
  $("#btn_save").html("<span class='fa fa-spin fa-spinner'></span> processing ...");
  
  var room_type = $("#room_type").val();
  $.ajax({
		type: "POST",
		url: "ajax/manageService.php",
		data: $('#frm_manage_services').serialize(),
		success: function(data){
			if(data == 1){
                if(type == "add"){
                    alertNotify('All Good!',"Successfully added entry!","success");
                }else{
                    alertNotify('All Good!',"Successfully updated entry!","success");
                }

                $('#frm_manage_services').each(function(){
                    this.reset();
                });
                $("#modalManageService").modal("hide");
                getServices();
            }else if(data == 2){
                alertNotify('Cannot Proceed!',"Room Type "+room_type+" already exist!","warning");
            }else{
                failed_query('Manage Room Type');
                alert(data);
			}

            $("#btn_save").html("<i class='material-icons'>check</i> Save Entry");
		    $("#btn_save").prop("disabled",false);
		}
		
	});
	
});


function getServices(){
  $("#dt_services").DataTable().destroy();
  $('#dt_services').DataTable({
    "processing":true,
    "responsive": true,
    "autoWidth": false,
    "ajax":{
      "url":"ajax/datatables/services.php",
      "dataSrc":"data"
    },
    "columns":[
        {
          "data":"checkbox"
        },
        {
          "data":"button"
        },
        {
            "data":"count"
        },
        {
            "data":"service"
        },
      <?php if($_SESSION['user_type'] == "S"){ ?>
        {
            "data":"hotel_id"
        },
      <?php } ?>
        {
            "data":"description"
        },
        {
            "data":"encoded_by"
        },
        {
            "data":"image"
        }
      ]
  });
}
</script>