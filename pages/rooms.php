<div class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header card-header-info">
            <h4 class="card-title">Rooms</h4>
            <p class="card-category"> Manage room entries</p>
          </div>
          <div class="card-body">
            <div class="col-md-12">
              <button class="btn btn-danger btn-sm pull-right" id="btn_delete" onclick="deleteEntry()"><span class="material-icons">delete_outline</span> Delete</button>
              <button type="button" class="btn btn-success btn-sm pull-right" onclick="modalManage('add')"><span class="material-icons">add_circle_outline</span> Add</button>
            </div>
            <div class="table-responsive">
              <div class="col-md-3">
                  <label>Type</label>
                  <select onchange="getRooms()" id="status_type" class="form-control">
                      <option value="all">ALL</option>
                      <option value="0">VACANT</option>
                      <option value="1">OCCUPIED</option>
                  </select>
              </div>
              <div class="col-lg-12" style="background-color:transparent;margin-top:10px;">
                  <table id="dt_rooms" class="table table-striped table-bordered" style="width:100%">
                    <thead style="padding: 10px;background-color: #607D8B;color: #fff;">
                        <tr>
                            <th><strong><input type='checkbox' onchange="checkAll(this,'room_id')"></strong></th>
                            <th><strong></strong></th>
                            <th><strong>#</strong></th>
                            <th><strong>Room</strong></th>
                          <?php if($_SESSION['user_type'] == "S"){ ?>
                            <th><strong>Hotel</strong></th>
                          <?php } ?>
                            <th><strong>Room type</strong></th>
                            <th><strong>Description</strong></th>
                            <th><strong>Status</strong></th>
                            <th><strong>Encoded By</strong></th>
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
<?php include 'pages/modals/modal_manage_room.php'; ?>
<?php include 'pages/modals/modal_img_rooms.php'; ?>
<!-- MODAL END -->
<script>
$(document).ready(function() {
  getRooms();
  var user_type = "<?= $_SESSION['user_type'] ?>";
  if(user_type == "A"){
    $("#div_hotel").hide();
    $("#hotel_id").html("<option value='<?= $_SESSION['hotel_id']; ?>'><?= getHotel($_SESSION['hotel_id']) ?></option>");
  }else{
    $("#div_hotel").show();
  }
});

function showModalUpdateImg(room_id,img){
  $("#modalHotelLogo").modal("show");
  $("#room_id_img").val(room_id);
  $("#div_logo").html("<img src='assets/room_img/"+img+"' rel='nofollow' alt='room'>");
}

$("#frm_room_img").submit(function(e){
    e.preventDefault();
    $.ajax({
		type: "POST",
        url: "ajax/uploadImgRoom.php",
        data: new FormData(this),
        processData: false,
        contentType: false,
        success: function(data){
		    if(data == 1){
			    success_update();
          getRooms();
        }else{
          failed_query("Upload Image");
          alert(data);
        }
		}
    });
});

function modalManage(type){
  
  $("#modalManageRoom").modal("show");
  $("#type").val(type);
}

function getEntryDetails(id){

  $("#modalManageRoom").modal("show");
  var tb = "tbl_rooms";
  var keyword = "room_id";

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
      $("#hotel_id").val(json.hotel_id);
      $("#room_id").val(json.room_id);
      $("#room_name").val(json.room_name);
      $("#room_description").val(json.room_description);
      $("#room_type").val(json.type_id);
      $("#room_rate").val(json.room_rate);
      $("#type").val(type);
    }
  });
}

function deleteEntry(){
  var count_checked = $("input[class='room_id']:checked").length;
  var tb = "tbl_rooms";
  var keyword = "room_id";

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
              var checkedValues = $("input[class='room_id']:checked").map(function() {
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
                          getRooms();
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

$("#frm_manage_room").submit(function(e){
  e.preventDefault();
  $("#btn_save").prop("disabled",true);
  $("#btn_save").html("<span class='fa fa-spin fa-spinner'></span> processing ...");
  
  var room_name = $("#room_name").val();
  $.ajax({
		type: "POST",
		url: "ajax/manageRoom.php",
		data: $('#frm_manage_room').serialize(),
		success: function(data){
			if(data == 1){
                if(type == "add"){
                    alertNotify('All Good!',"Successfully added entry!","success");
                }else{
                    alertNotify('All Good!',"Successfully updated entry!","success");
                }

                $('#frm_manage_room').each(function(){
                    this.reset();
                });
                $("#modalManageRoom").modal("hide");
                getRooms();
            }else if(data == 2){
                alertNotify('Cannot Proceed!',"Room "+room_name+" already exist!","warning");
            }else{
                failed_query('Manage Room');
                alert(data);
			}

        $("#btn_save").html("<i class='material-icons'>check</i> Save Entry");
		    $("#btn_save").prop("disabled",false);
		}
		
	});
	
});


function getRooms(){
  var status_type = $("#status_type").val();
  $("#dt_rooms").DataTable().destroy();
  $('#dt_rooms').DataTable({
    "processing":true,
    "responsive": true,
    "autoWidth": false,
    "ajax":{
      "type":"POST",
        "url":"ajax/datatables/rooms.php",
        "dataSrc":"data",
        "data":{
            status_type:status_type
        }
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
            "data":"room"
        },
      <?php if($_SESSION['user_type'] == "S"){ ?>
        {
            "data":"hotel_id"
        },
      <?php } ?>
        {
            "data":"room_type"
        },
        {
            "data":"description"
        },
        {
            "data":"status"
        },
        {
            "data":"encoded_by"
        }
      ]
  });
}
</script>