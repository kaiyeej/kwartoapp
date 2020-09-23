<?php
header("Access-Control-Allow-Origin: *");
require_once '../../core/config.php';

$type_id = $_POST['type_id'];
?>
<?php
    $fetchRoom = $mysqli_connect->query("SELECT * FROM tbl_room_type WHERE type_id='$type_id'");
    $row = $fetchRoom->fetch_array();
        if(empty($row['room_img'])){
            $img = "images/no_img.jpg";
        }else{
            $img = server_url()."/assets/room_img/".$row['room_img'];
        }
?>
        <!-- Room -->
        
        <input type="hidden" id="current_date">
        <div class="card">
            <div class="card-body">
                <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
                  <ol class="carousel-indicators">
                  <?php
                    $fetchImg2 = $mysqli_connect->query("SELECT * FROM tbl_room_type_image WHERE type_id='$type_id'");
                    $count_img2 = 0;
                    while($rowImg2 = $fetchImg2->fetch_array()){
                      $count_img2 += 1;
                  ?>
                    <li data-target="#carouselExampleIndicators" data-slide-to="<?= ($count_img2-1) ?>" class="<?php if($count_img2 <= 1){ echo "active"; } ?>"></li>
                  <?php } ?>
                  </ol>
                  <div class="carousel-inner">

                  <?php
                    $fetchImg = $mysqli_connect->query("SELECT * FROM tbl_room_type_image WHERE type_id='$type_id'");
                    $count_img = 0;
                    while($rowImg = $fetchImg->fetch_array()){
                      $count_img += 1;
                  ?>
                    <div class="carousel-item <?php if($count_img <= 1){ echo "active"; } ?>">
                      <img class="d-block w-100" src="<?= server_url()."/assets/room_img/".$rowImg['room_img'] ?>">
                    </div>

                  <?php } ?>
                  </div>
                  <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="sr-only">Previous</span>
                  </a>
                  <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="sr-only">Next</span>
                  </a>
                </div>
  
                <h3 class="profile-username text-center"><?= $row['room_type']; ?></h3>
    
                <p class="text-muted text-center"><?= getHotel($row['hotel_id']); ?></p>
    
                <ul class="list-group list-group-unbordered mb-3">
                    <li class="list-group-item">
                        <b>Price</b> <a class="float-right">&#8369;<?= number_format($row['room_rate'],2); ?>/night</a>
                    </li>
                    <li class="list-group-item">
                        <b>Capacity</b> <a class="float-right"><?php if($row['capacity'] == 1){ echo $row['capacity']." adult"; }else if($row['capacity'] <= 3){ echo $row['capacity']." adults"; }else{ "Family"; } ?></a>
                    </li>
                    <li class="list-group-item">
                        <b>Description</b> <a class="float-right" style="word-break:break-all;"><?= $row['remarks']; ?></a>
                    </li>
                    <li class="list-group-item" style="padding: 0px;">
                        <div class="form-group">
                            <label>Date arrival:</label>
                            <input type="date" name="start_date" required id="start_date" class="form-control pull-right">
                        </div>
                    </li>
                    <li class="list-group-item" style="padding: 0px;">
                        <div class="form-group">
                            <label>Date departure:</label>
                            <input type="date" name="end_date" required id="end_date" class="form-control pull-right">
                        </div>
                    </li>
                </ul>
                <a href="#" onclick="bookNow(<?= $row[0]; ?>)" class="btn btn-outline-primary btn-block"><b>Book now</b></a>
            </div>
        </div>
<script>
$( document ).ready(function() {
	var now = new Date();
  var day = ("0" + now.getDate()).slice(-2);
  var month = ("0" + (now.getMonth() + 1)).slice(-2);
  var today = now.getFullYear()+"-"+(month)+"-"+(day);
  $('#current_date').val(today);

});

</script>
