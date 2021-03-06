<?php
header("Access-Control-Allow-Origin: *");
require_once '../../core/config.php';

$service_id = $_POST['service_id'];
$user_id = $_POST['user_id'];
?>
<?php
    $fetchRoom = $mysqli_connect->query("SELECT * FROM tbl_services WHERE service_id='$service_id'");
    $row = $fetchRoom->fetch_array();
        if(empty($row['service_img'])){
            $img = "images/no_img.jpg";
        }else{
            $img = server_url()."/assets/service_img/".$row['service_img'];
        }
?>
        <!-- Room -->
        <div class="card">
            <div class="card-body">
                <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
                  <ol class="carousel-indicators">
                  <?php
                    $fetchImg2 = $mysqli_connect->query("SELECT * FROM tbl_service_image WHERE service_id='$service_id'");
                    $count_img2 = 0;
                    while($rowImg2 = $fetchImg2->fetch_array()){
                      $count_img2 += 1;
                  ?>
                    <li data-target="#carouselExampleIndicators" data-slide-to="<?= ($count_img2-1) ?>" class="<?php if($count_img2 <= 1){ echo "active"; } ?>"></li>
                  <?php } ?>
                  </ol>
                  <div class="carousel-inner">

                  <?php
                    $fetchImg = $mysqli_connect->query("SELECT * FROM tbl_service_image WHERE service_id='$service_id'");
                    $count_img = 0;
                    while($rowImg = $fetchImg->fetch_array()){
                      $count_img += 1;
                  ?>
                    <div class="carousel-item <?php if($count_img <= 1){ echo "active"; } ?>">
                      <img class="d-block w-100" src="<?= server_url()."/assets/service_img/".$rowImg['service_img'] ?>">
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
  
                <h3 class="profile-username text-center"><?= $row['service']; ?></h3>
    
                <p class="text-muted text-center"><?= getHotel($row['hotel_id']); ?></p>
    
                <ul class="list-group list-group-unbordered mb-3">
                    <li class="list-group-item">
                        <b>Price</b> <a class="float-right">&#8369;<?= number_format($row['service_rate'],2); ?></a>
                    </li>
                    <li class="list-group-item">
                        <b>Description</b> <a class="float-right" style="word-break:break-all;"><?= $row['service_description']; ?></a>
                    </li>
                </ul>
                <?php
                    $fetchReserve = $mysqli_connect->query("SELECT * FROM tbl_reservation WHERE hotel_id='$row[hotel_id]' AND customer_id='$user_id' AND status = 'S'");
                    if(mysqli_num_rows($fetchReserve) > 0){
                ?>
                    <button onclick="bookNow(<?= $row[0]; ?>)" class="btn btn-outline-primary btn-block"><b>Book now</b></button>
                <?php } ?>
            </div>
        </div>
