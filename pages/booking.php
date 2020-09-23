<div class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header card-header-info">
            <h4 class="card-title">Booking</h4>
            <p class="card-category"> Manage booking transactions</p>
          </div>
          <div class="card-body">
            <div class="col-md-12">
              <button type="button" class="btn btn-success btn-sm pull-right" onclick="modalManage('add')"><span class="material-icons">add_circle_outline</span> Add</button>
            </div>
            <div class="col-md-3">
                <label>Type</label>
                <select onchange="getBooking()" id="status_type" class="form-control">
                    <option value="all">ALL</option>
                    <option value="P">Pending</option>
                    <option value="A">Approved</option>
                    <option value="I">Check-in</option>
                    <option value="O">Check-out</option>
                    <option value="C">Cancel</option>
                </select>
            </div>
            <div class="table-responsive">
              <div class="col-lg-12" style="background-color:transparent;margin-top:10px;">
                  <table id="dt_booking" class="table table-striped table-bordered" style="width:100%">
                    <thead style="padding: 10px;background-color: #607D8B;color: #fff;">
                        <tr>
                            <th><strong></strong></th>
                            <th><strong>#</strong></th>
                            <th><strong>Reservation #</strong></th>
                            <th><strong>Customer</strong></th>
                            <th><strong>Date</strong></th>
                            <th><strong>Status</strong></th>
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
<?php include 'pages/modals/modal_manage_booking.php'; ?>
<!-- MODAL END -->
<script>

$(document).ready(function() {
  getBooking();
  var date_today = $("#date_today").val();
  $('#start_date').dateTimePicker({
      mode:'date',
      limitMin: date_today,
      limitMax: null
    });

    $('#end_date').dateTimePicker({
      mode:'date',
      limitMin: date_today,
      limitMax: null
    });

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

function sumTotal(){
    var service_type = $("#service_type").val();
    var service_id = $("#service_id").val();
    var qty = $("#qty").val();
    $.ajax({
        type: "POST",
        url: "ajax/sumTotalService.php",
        data: {
            service_type:service_type,
            service_id:service_id,
            qty:qty
        },
        success: function(data){
            $("#span_total").html(data);
        }
    });
    
}

function getService(){
    var service_type = $("#service_type").val();
    $.ajax({
        type: "POST",
        url: "ajax/getService.php",
        data: {
            service_type:service_type
        },
        success: function(data){
            if(service_type == "R"){
                $("#qty").prop("readonly",true);
                $("#qty").val(1);
            }else{
                $("#qty").prop("readonly",false);
            }
            $("#div_service_room").html(data);
        }
    });
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

function getRoom(){
    var type_id = $("#type_id").val();
    var start_date = $("#start_date").val();
    var end_date = $("#end_date").val();
    $.ajax({
        type: "POST",
        url: "ajax/roomDropdown.php",
        data: {
            type_id:type_id,
            end_date:end_date,
            start_date:start_date
        },
        success: function(data){
            $("#room_id").html(data);
        }
    });
}

function viewBooking(id){
    $("#modalManageBooking").modal("show");
}

function modalManage(type){
    $('#frm_add_booking').each(function(){
        this.reset();
    });
    $("#modalManageBooking").modal("show");
    $("#type").val(type);

    generateRefNum();

    $(".div_room_header").show();
    $("#div_addtional").hide();
    $("#div_table").hide();
}

function generateRefNum(){
    $.ajax({
        type:"POST",
        url:"ajax/generateRefNum.php",
        success: function(data){
            $("#ref_number").val(data);
            $("#refNum").val(data);
            $("#span_ref").html(data);
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
                alert(data);
            }
        }
    });
}

function deleteDetails(id){
  var tb = "tbl_reservation_details";
  var keyword = "rsd_id";

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
              
              $("#btn_delete").prop('disabled', true);
              $("#btn_delete").html("<span class='fa fa-spinner fa-spin' style='color:#fff;'></span> processing ...");

              $.ajax({
                  type:"POST",
                  url:"ajax/deleteEntries.php",
                  data:{
                      id:id,
                      tb:tb,
                      keyword:keyword
                  },
                  success:function(data){
                      if(data == 1){
                          //alert('Successfully deleted entries.');
                          success_delete();
                          getBookingDetails();
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
}


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
                          getBooking();
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

$("#frm_add_booking").submit(function(e){
  e.preventDefault();
  $("#btn_save").prop("disabled",true);
  $("#btn_save").html("<span class='fa fa-spin fa-spinner'></span> processing ...");
  
    $.ajax({
        type: "POST",
        url: "ajax/addBooking.php",
        data: $('#frm_add_booking').serialize(),
        success: function(data){
            if(data == 2){
                alertNotify('Cannot Procced!',"Room is not available","warning");
            }else if(data == 1){
                if(type == "add"){
                    alertNotify('All Good!',"Successfully added entry!","success");
                }
                $(".div_room_header").hide();
                $("#div_addtional").show();
                $("#div_table").show();
                getBookingDetails();
                getBooking();
            }else{
                failed_query('Manage Booking');
                alert(data);
            }
            $("#btn_save").html("<i class='material-icons'>check</i> Save Entry");
            $("#btn_save").prop("disabled",false);
        }
    });
	
});

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

function getBooking(){
  var status_type = $("#status_type").val();
  $("#dt_booking").DataTable().destroy();
  $('#dt_booking').DataTable({
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
            "data":"date"
        },
        {
            "data":"status"
        }
      ]
  });
}
</script>