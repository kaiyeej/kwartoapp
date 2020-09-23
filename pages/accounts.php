<div class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header card-header-info">
            <h4 class="card-title">Accounts</h4>
            <p class="card-category"> Manage account entries</p>
          </div>
          <div class="card-body">
            <div class="col-md-12">
              <button class="btn btn-danger btn-sm pull-right" id="btn_delete" onclick="deleteEntry()"><span class="material-icons">delete_outline</span> Delete</button>
              <button type="button" class="btn btn-success btn-sm pull-right" onclick="modalManage('add')"><span class="material-icons">add_circle_outline</span> Add</button>
            </div>
            <div class="table-responsive">
              <div class="col-lg-12" style="background-color:transparent;margin-top:10px;">
                  <table id="dt_accounts" class="table table-striped table-bordered" style="width:100%">
                    <thead style="padding: 10px;background-color: #607D8B;color: #fff;">
                        <tr>
                            <th><strong><input type='checkbox' onchange="checkAll(this,'user_id')"></strong></th>
                            <th><strong></strong></th>
                            <th><strong>#</strong></th>
                            <th><strong>Name</strong></th>
                          <?php if($_SESSION['user_type'] == "S"){ ?>
                            <th><strong>Hotel</strong></th>
                          <?php } ?>
                            <th><strong>Account Type</strong></th>
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
<?php include 'pages/modals/modal_manage_accounts.php'; ?>
<!-- MODAL END -->
<script>
$(document).ready(function() {
  getAccounts();

  var user_type = "<?= $_SESSION['user_type'] ?>";
  if(user_type == "A"){
    $("#div_hotel").hide();
    $("#hotel_id").html("<option value='<?= $_SESSION['hotel_id']; ?>'><?= getHotel($_SESSION['hotel_id']) ?></option>");
  }else{
    $("#div_hotel").show();
  }
});

function modalManage(type){
    $('#frm_manage_account').each(function(){
        this.reset();
    });
    $("#modalManageAccount").modal("show");
    $("#type").val(type);
    $("#div_pass").show();
    $("#password").prop("disabled",false);
}

function getEntryDetails(id){

  $("#modalManageAccount").modal("show");
  var tb = "tbl_users";
  var keyword = "user_id";

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
      
      $("#user_id").val(json.user_id);
      $("#name").val(json.name);
      $("#address").html(json.address);
      $("#contact_number").val(json.contact_number);
      $("#email").val(json.email);
      $("#username").val(json.username);
      $("#div_pass").hide();
      $("#password").val("-1");

      if(json.user_type == "S"){
        $("#hotel_id").val(0);
        $("#div_hotel").hide();
      }else{
        $("#hotel_id").val(json.hotel_id);
        $("#div_hotel").show();
      }

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
                          getAccounts();
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

$("#frm_manage_account").submit(function(e){
  e.preventDefault();
  $("#btn_save").prop("disabled",true);
  $("#btn_save").html("<span class='fa fa-spin fa-spinner'></span> processing ...");
  
  var username = $("#username").val();
  $.ajax({
		type: "POST",
		url: "ajax/manageAccounts.php",
		data: $('#frm_manage_account').serialize(),
		success: function(data){
			if(data == 1){
                if(type == "add"){
                    alertNotify('All Good!',"Successfully added entry!","success");
                }else{
                    alertNotify('All Good!',"Successfully updated entry!","success");
                }

                $('#frm_manage_account').each(function(){
                    this.reset();
                });
                $("#modalManageAccount").modal("hide");
                getAccounts();
            }else if(data == 2){
                alertNotify('Cannot Proceed!',"Username "+username+" already exist!","warning");
            }else{
                failed_query('Manage Accounts');
                alert(data);
			}

            $("#btn_save").html("<i class='material-icons'>check</i> Save Entry");
		    $("#btn_save").prop("disabled",false);
		}
		
	});
	
});


function getAccounts(){
  $("#dt_accounts").DataTable().destroy();
  $('#dt_accounts').DataTable({
    "processing":true,
    "responsive": true,
    "autoWidth": false,
    "ajax":{
      "url":"ajax/datatables/accounts.php",
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
            "data":"name"
        },
      <?php if($_SESSION['user_type'] == "S"){ ?>
        {
            "data":"hotel_id"
        },
      <?php } ?>
        {
            "data":"account_type"
        },
        {
            "data":"encoded_by"
        }
      ]
  });
}
</script>