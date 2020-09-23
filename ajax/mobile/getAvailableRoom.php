<?php
header("Access-Control-Allow-Origin: *");
require_once '../../core/config.php';

$start_date = $_POST['start_date'];
$end_date = $_POST['end_date'];
$capacity = $_POST['capacity'];
?>
<?php
    $fetchRoom = $mysqli_connect->query("SELECT * FROM tbl_room_type");
    while($row = $fetchRoom->fetch_array()){
        $status = room_status($row['type_id'],$start_date,$end_date);
        
       if($status == 0){
            if(empty($row['room_img'])){
                $img = "images/no_img.jpg";
            }else{
                $img = server_url()."/assets/room_img/".$row['room_img'];
            }
?>
        <!-- Room -->
        <div class="card">
            <div class="card-body box-profile">
              <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
                  <ol class="carousel-indicators">
                    <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
                    <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
                    <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
                  </ol>
                  <div class="carousel-inner">
                    <div class="carousel-item active">
                      <img class="d-block w-100" src="https://placehold.it/900x500/39CCCC/ffffff&text=I+Love+Bootstrap" alt="First slide">
                    </div>
                    <div class="carousel-item">
                      <img class="d-block w-100" src="https://placehold.it/900x500/3c8dbc/ffffff&text=I+Love+Bootstrap" alt="Second slide">
                    </div>
                    <div class="carousel-item">
                      <img class="d-block w-100" src="https://placehold.it/900x500/f39c12/ffffff&text=I+Love+Bootstrap" alt="Third slide">
                    </div>
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
              </ul>
              <a href="#" onclick="bookNow(<?= $row[0]; ?>)" class="btn btn-outline-primary btn-block"><b>Book now</b></a>
            </div>
        </div>
<?php 
        }
    } ?>

