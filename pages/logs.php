<div class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header card-header-info">
            <h4 class="card-title">Logs</h4>
            <p class="card-category"> Log entries</p>
          </div>
          <div class="card-body">
            <div class="table-responsive">
              <div class="col-lg-12" style="background-color:transparent;margin-top:10px;">
                  <table id="dt_logs" class="table table-striped table-bordered" style="width:100%">
                    <thead style="padding: 10px;background-color: #607D8B;color: #fff;">
                        <tr>
                            <th><strong>#</strong></th>
                            <th><strong>Action</strong></th>
                            <th><strong>User</strong></th>
                            <th><strong>Date Added</strong></th>
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
<!-- MODAL END -->
<script>
$(document).ready(function() {
    getLogs();
});

function getLogs(){
  $("#dt_logs").DataTable().destroy();
  $('#dt_logs').DataTable({
    "processing":true,
    "responsive": true,
    "autoWidth": false,
    "ajax":{
      "url":"ajax/datatables/logs.php",
      "dataSrc":"data"
    },
    "columns":[
       {
           "data":"count"
       },
       {
           "data":"action"
       },
       {
           "data":"user"
       },
       {
           "data":"date_added"
       }
      ]
  });
}
</script>