<?php
header("Access-Control-Allow-Origin: *");
require_once '../../core/config.php';

$hotel_id = $_POST['hotel_id'];
?>
<div class="container-fluid">
    <!-- Default box -->
    <div class="card card-primary card-outline">
      <form id="frm_search_room" method="POST" action="">
      <div class="card-body">
        <div class="form-group">
            <label>Capacity</label>
              <select class="form-control select2" required onchange="getRooms()" name="capacity" id="capacity" style="width: 30%;">
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="4">Family</option>
              </select>
        </div>
      </div>
      <!-- /.card-body -->
    </div>
    <!-- /.card -->
</div>
<div class="container-fluid">
    <div class="ard card-primary ">
        <div id="div_available_room">
        </div>
    </div>
</div>

<script>
$( document ).ready(function() {
    getRooms();
});

function getRooms(){
    var capacity = $("#capacity").val();
    var hotel_id = "<?= $hotel_id; ?>";
    $.ajax({
		type:"POST",
        url: server_url()+"ajax/mobile/roomByCategory2.php",
        data:{
            capacity:capacity,
            hotel_id:hotel_id
        },
        success:function(data){
            $("#div_available_room").html(data);
        }
    });
}

</script>