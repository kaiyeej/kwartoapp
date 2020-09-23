<div class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header card-header-info">
            <h4 class="card-title">Hotels</h4>
            <p class="card-category"> Manage hotel entries</p>
          </div>
          <div class="card-body">
            <div class="col-md-12">
              <button class="btn btn-danger btn-sm pull-right" id="btn_delete" onclick="deleteEntry()"><span class="material-icons">delete_outline</span> Delete</button>
              <button type="button" class="btn btn-success btn-sm pull-right" onclick="modalManage('add')"><span class="material-icons">add_circle_outline</span> Add</button>
            </div>
            <div class="table-responsive">
              <div class="col-lg-12" style="background-color:transparent;margin-top:10px;">
                  <table id="dt_hotels" class="table table-striped table-bordered" style="width:100%">
                    <thead style="padding: 10px;background-color: #607D8B;color: #fff;">
                        <tr>
                            <th><strong><input type='checkbox' onchange="checkAll(this,'hotel_id')"></strong></th>
                            <th><strong></strong></th>
                            <th><strong>#</strong></th>
                            <th><strong>Hotel</strong></th>
                            <th><strong>Description</strong></th>
                            <th><strong>Address</strong></th>
                            <th><strong>Contact #</strong></th>
                            <th><strong>Image</strong></th>
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
<?php include 'pages/modals/modal_manage_hotels.php'; ?>
<?php include 'pages/modals/modal_img_hotels.php'; ?>
<!-- MODAL END -->
<script>
$(document).ready(function() {
  getHotels();
});

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
          getHotels();
        }else{
          failed_query("Upload Image");
          alert(data);
        }
		}
    });
});

function showModalUpdateImg(hotel_id,img){
  $("#modalHotelLogo").modal("show");
  $("#hotel_id_mg").val(hotel_id);
  $("#div_logo").html("<img src='assets/hotel_img/"+img+"' rel='nofollow' alt='...'>");
}

function modalManage(type){
  $("#modalManageHotel").modal("show");
  $("#type").val(type);
}

function getEntryDetails(id){

  $("#modalManageHotel").modal("show");
  var tb = "tbl_hotels";
  var keyword = "hotel_id";

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
      $("#hotel_name").val(json.hotel_name);
      $("#hotel_address").val(json.hotel_address);
      $("#hotel_contact_number").val(json.hotel_contact_number);
      $("#hotel_email").val(json.hotel_email);
      $("#hotel_description ").val(json.hotel_description);
      $("#type").val(type);
    }
  });
}

function deleteEntry(){
  var count_checked = $("input[class='hotel_id']:checked").length;
  var tb = "tbl_hotels";
  var keyword = "hotel_id";

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
              var checkedValues = $("input[class='hotel_id']:checked").map(function() {
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
                          getHotels();
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

$("#frm_manage_hotel").submit(function(e){
  e.preventDefault();
  $("#btn_add").prop("disabled",true);
  $("#btn_add").html("<span class='fa fa-spin fa-spinner'></span> processing ...");
  
  var hotel_name = $("#hotel_name").val();
  $.ajax({
		type: "POST",
		url: "ajax/manageHotel.php",
		data: $('#frm_manage_hotel').serialize(),
		success: function(data){
			if(data == 1){
        if(type == "add"){
          alertNotify('All Good!',"Successfully added entry!","success");
        }else{
          alertNotify('All Good!',"Successfully updated entry!","success");
        }

        $('#frm_manage_hotel').each(function(){
          this.reset();
        });
        $("#modalManageHotel").modal("hide");
        getHotels();
			}else if(data == 2){
        alertNotify('Cannot Proceed!',"Hotel "+hotel_name+" already exist!","warning");
			}else{
        failed_query('Manage Hotel');
			}

      $("#btn_add").html("<span class='fas fa-check-circle'></span> Save");
		  $("#btn_add").prop("disabled",false);
		}
		
	});
	
});


function getHotels(){
  $("#dt_hotels").DataTable().destroy();
  $('#dt_hotels').DataTable({
    "processing":true,
    "responsive": true,
    "autoWidth": false,
    "ajax":{
      "url":"ajax/datatables/hotels.php",
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
            "data":"hotel"
        },
        {
            "data":"description"
        },
        {
            "data":"address"
        },
        {
            "data":"contact_no"
        },
        {
            "data":"image"
        },
        {
            "data":"encoded_by"
        }
      ]
  });
}
</script>