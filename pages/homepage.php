<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-transparent navbar-absolute fixed-top ">
        <div class="container-fluid">
          <div class="navbar-wrapper">
          </div>
          <button class="navbar-toggler" type="button" data-toggle="collapse" aria-controls="navigation-index" aria-expanded="false" aria-label="Toggle navigation">
            <span class="sr-only">Toggle navigation</span>
            <span class="navbar-toggler-icon icon-bar"></span>
            <span class="navbar-toggler-icon icon-bar"></span>
            <span class="navbar-toggler-icon icon-bar"></span>
          </button>
        </div>
      </nav>
      <!-- End Navbar -->
      <div class="content">
        <div class="container-fluid">
          <div class="row">
            <div class="col-lg-3 col-md-6 col-sm-6">
              <div class="card card-stats">
                <div style="height: 85px;" class="card-header card-header-warning card-header-icon">
                  <div class="card-icon">
                    <i class="material-icons">hotel</i>
                  </div>
                  <p class="card-category">Occupied Room</p>
                  <h3 class="card-title"><?= occupiedRoom(); ?>/<?= totalRoom(); ?>
                  </h3>
                </div>
                <div class="card-footer">
                </div>
              </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6">
              <div class="card card-stats">
                <div style="height: 85px;" class="card-header card-header-success card-header-icon">
                  <div class="card-icon">
                    <i class="material-icons">single_bed</i>
                  </div>
                  <p class="card-category">Vacant Room</p>
                  <h3 class="card-title"><?= vacantRoom(); ?>/<?= totalRoom(); ?>
                  </h3>
                </div>
                <div class="card-footer">
                </div>
              </div>
            </div>
            <div class="col-lg-3 col-md-4 col-sm-6">
              <div class="card card-stats">
                <div style="height: 85px;" class="card-header card-header-info card-header-icon">
                  <div class="card-icon">
                    <i class="material-icons">group</i>
                  </div>
                  <p class="card-category">Expected Arrival<br>for today</p>
                  <h3 class="card-title"><?= expectedArrival();?>
                  </h3>
                </div>
                <div class="card-footer">
                </div>
              </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6">
              <div class="card card-stats">
                <div style="height: 85px;" class="card-header card-header-danger card-header-icon">
                  <div class="card-icon">
                    <i class="material-icons">work  </i>
                  </div>
                  <p class="card-category">Expected Departure<br>for today</p>
                  <h3 class="card-title"><?= expectedDeparture();?>
                  </h3>
                </div>
                <div class="card-footer">
                </div>
              </div>
            </div>
            </div>
          </div>
          <div class="row">
            <div class="col-lg-6">
              <div class="card">
                <div class="card-header card-header-success">
                  <h4 class="card-title">Expected Arrival</h4>
                  <p class="card-category">Manage customer arrival</p>
                </div>
                <div class="card-body table-responsive">
                  <table id="dt_arrival" class="table table-striped table-bordered" style="width:100%">
                    <thead style="padding: 10px;">
                        <tr>
                            <th><strong></strong></th>
                            <th><strong>#</strong></th>
                            <th><strong>Reservation #</strong></th>
                            <th><strong>Customer</strong></th>
                            <th><strong>Room</strong></th>
                            <th><strong>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
            <div class="col-lg-6">
              <div class="card">
                <div class="card-header card-header-warning">
                  <h4 class="card-title">Expected Departure</h4>
                  <p class="card-category">Manage customer departure</p>
                </div>
                <div class="card-body table-responsive">
                  <table id="dt_departure" class="table table-striped table-bordered" style="width:100%">
                    <thead style="padding: 10px;">
                        <tr>
                            <th><strong></strong></th>
                            <th><strong>#</strong></th>
                            <th><strong>Reservation #</strong></th>
                            <th><strong>Customer</strong></th>
                            <th><strong>Room</strong></th>
                            <th><strong>Date</th>
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

<!-- MODAL START -->
<?php include 'pages/modals/modal_manage_booking.php'; ?>
<!-- MODAL END -->
<script>

$(document).ready(function() {
  getArrival();
  getDeparture();
});

function assignRoom(id){
  var room_id = $("#assign_room").val();
    
    if(room_id == -1){
        alertNotify("Opss!","Select room first.","warning");
    }else{
        $("#btn_assign"+id).prop('disabled', true);
        $("#btn_assign"+id).html("<span class='fa fa-spinner fa-spin' style='color:#fff;'></span>");

        $.ajax({
            type: "POST",
            url: "ajax/assignRoom.php",
            data:{
                room_id:room_id,
                id:id
            },
            success: function(data){
                if(data == 1){
                    alertNotify('All Good!',"Successfully assigned room!","success");
                }else{
                    failed_query(data);
                }

                $("#btn_assign"+id).prop('disabled', true);
                $("#btn_assign"+id).html('<span class="material-icons">add_circle_outline</span>');
            }
        });
    }
}

function getCustomer(){
    var customer_type = $("#customer_type").val();
    $.ajax({
        type: "POST",
        url: "ajax/getCustomer.php",
        data: {
            customer_type:customer_type
        },
        success: function(data){
            $("#div_customer").html(data);
        }
    });
}

function getEntryDetails(id){
  $("#modalManageBooking").modal("show");
  var tb = "tbl_reservation";
  var keyword = "reservation_id";

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
      $("#reservation_id").val(json.reservation_id);
      $("#ref_number").val(json.ref_number);
      $("#refNum").val(json.ref_number);
      $("#span_ref").html(json.ref_number);
      
      $("#start_date").val(json.start_date);
      $("#end_date").val(json.end_date);
      
      if(json.customer_id == 0){
        $("#customer_type").html("<option value='1'>Walk-in</option>");
        $("#customer_id").val(json.walk_in);
      }else{
        $("#customer_type").html("<option value='0'>Existing Customer</option>");
        getCustomer();
        $("#customer_id").val(json.customer_id);
      }
      $(".div_room_header").hide();
      if(json.status != 'F'){
        $("#div_addtional").show();
      }else{
        $("#div_addtional").hide();
      }
      $("#div_table").show();
      getBookingDetails();
    }
  });
}

function cancelBooking(id){
    $("#btn_cancel"+id).prop("disabled",true);
    $("#btn_cancel"+id).html("<span class='fa fa-spin fa-spinner'></span>");
  
    $.ajax({
        type: "POST",
        url: "ajax/cancelBooking.php",
        data: {
            id:id
        },
        success: function(data){
            if(data == 2){
                alertNotify('Cannot Procced!',"Room is not available","warning");
            }else if(data == 1){
                if(type == "add"){
                    alertNotify('All Good!',"Successfully cancel entry!","success");
                }
                getBooking();
            }else{
                failed_query('Manage Booking');
                alert(data);
            }
            $("#btn_cancel"+id).hide();
        }
    });
}

function getBookingDetails(){
    var ref_number = $("#ref_number").val();

    $("#dt_booking_details").DataTable().destroy();
    $('#dt_booking_details').DataTable({
        "processing":true,
        "responsive": true,
        "autoWidth": false,
        "ajax":{
            "type":"POST",
            "url":"ajax/datatables/booking_details.php",
            "dataSrc":"data",
            "data":{
                ref_number:ref_number
            }
        },
        "columns":[
            {
            "data":"button"
            },
            {
                "data":"count"
            },
            {
                "data":"type"
            },
            {
                "data":"service_room"
            },
            {
                "data":"qty"
            },
            {
                "data":"amount"
            }
        ]
    });
}


$("#frm_add_booking_details").submit(function(e){
  e.preventDefault();
  $("#btn_save_details").prop("disabled",true);
  $("#btn_save_details").html("<span class='fa fa-spin fa-spinner'></span> processing ...");
  
    $.ajax({
        type: "POST",
        url: "ajax/addBookingDetails.php",
        data: $('#frm_add_booking_details').serialize(),
        success: function(data){
            if(data == 2){
                alertNotify('Cannot Procced!',"Room is not available","warning");
            }else if(data == 1){
                if(type == "add"){
                    alertNotify('All Good!',"Successfully added entry!","success");
                }
                
                getBookingDetails();
            }else{
                failed_query('Manage Booking');
                alert(data);
            }
            $("#btn_save_details").html("<i class='material-icons'>check</i> Save Entry");
            $("#btn_save_details").prop("disabled",false);
        }
    });
	
});

function deleteEntry(){
  var count_checked = $("input[class='user_id']:checked").length;
  var tb = "tbl_users";
  var keyword = "user_id";

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
              var checkedValues = $("input[class='user_id']:checked").map(function() {
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
                          location.reload();
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

function getBookingDetails(){
    var ref_number = $("#ref_number").val();

    $("#dt_booking_details").DataTable().destroy();
    $('#dt_booking_details').DataTable({
        "processing":true,
        "responsive": true,
        "autoWidth": false,
        "ajax":{
            "type":"POST",
            "url":"ajax/datatables/booking_details.php",
            "dataSrc":"data",
            "data":{
                ref_number:ref_number
            }
        },
        "columns":[
            {
            "data":"button"
            },
            {
                "data":"count"
            },
            {
                "data":"type"
            },
            {
                "data":"service_room"
            },
            {
                "data":"qty"
            },
            {
                "data":"amount"
            }
        ]
    });
}

function updateStatus(id){
    $.ajax({
        type:"POST",
        url:"ajax/updateResevationStatus.php",
        data: {
            id:id
        },
        success: function(data){
            if(data == 1){
                success_update();
                location.reload();
            }else if(data == 2){
                alert('No room details found! Please assign room first.');
            }else{
                failed_query("Update Status");
            }
        }
    });
}


function getDeparture(){
var status_type = "DT";
  $("#dt_departure").DataTable().destroy();
  $('#dt_departure').DataTable({
    "processing":true,
    "responsive": true,
    "autoWidth": false,
    "ajax":{
        "type":"POST",
        "url":"ajax/datatables/booking.php",
        "dataSrc":"data",
        "data":{
            status_type:status_type
        }
    },
    "columns":[
        {
          "data":"button"
        },
        {
            "data":"count"
        },
        {
            "data":"reservation_number"
        },
        {
            "data":"customer"
        },
        {
            "data":"remarks"
        },
        {
            "data":"date"
        }
      ]
  });
}

function getArrival(){
var status_type = "AT";
  $("#dt_arrival").DataTable().destroy();
  $('#dt_arrival').DataTable({
    "processing":true,
    "responsive": true,
    "autoWidth": false,
    "ajax":{
        "type":"POST",
        "url":"ajax/datatables/booking.php",
        "dataSrc":"data",
        "data":{
            status_type:status_type
        }
    },
    "columns":[
        {
          "data":"button"
        },
        {
            "data":"count"
        },
        {
            "data":"reservation_number"
        },
        {
            "data":"customer"
        },
        {
            "data":"remarks"
        },
        {
            "data":"date"
        }
      ]
  });
}
</script>
