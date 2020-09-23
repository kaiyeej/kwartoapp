<?php
header("Access-Control-Allow-Origin: *");
require_once '../../core/config.php';

$capacity = $_POST['capacity'];
$hotel_id = $_POST['hotel_id'];
?>
<?php
    $fetchRoom = $mysqli_connect->query("SELECT * FROM tbl_room_type WHERE capacity='$capacity' AND hotel_id='$hotel_id'");
    $counter = 0;
    while($row = $fetchRoom->fetch_array()){
        $counter += 1;
        $type_id = $row['type_id'];
        if(empty($row['room_img'])){
            $img = "images/no_img.jpg";
        }else{
            $img = server_url()."/assets/room_img/".$row['room_img'];
        }
?>
        <!-- Room -->
        <div class="card" style="padding:30px;">
            <div class="card-body box-profile">
                <div id="carouselExampleIndicators<?= $counter ?>" class="carousel slide" data-ride="carousel">
                  <ol class="carousel-indicators">
                  <?php
                    $fetchImg2 = $mysqli_connect->query("SELECT * FROM tbl_room_type_image WHERE type_id='$type_id'");
                    $count_img2 = 0;
                    while($rowImg2 = $fetchImg2->fetch_array()){
                      $count_img2 += 1;
                  ?>
                    <li data-target="#carouselExampleIndicators<?= $counter ?>" data-slide-to="<?= ($count_img2-1) ?>" class="<?php if($count_img2 <= 1){ echo "active"; } ?>"></li>
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
                  <a class="carousel-control-prev" href="#carouselExampleIndicators<?= $counter ?>" role="button" data-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="sr-only">Previous</span>
                  </a>
                  <a class="carousel-control-next" href="#carouselExampleIndicators<?= $counter ?>" role="button" data-slide="next">
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
                <div class="text-center">
                  <a href="#" onclick="window.location='room_details.html?id=<?= $row[0] ?>'" class="btn btn-outline-primary" style="width:50%;"><b>View Details</b></a>
                <d/iv>
            </div>
        </div>
<?php
    }

    if($counter <= 0){ ?>
        <div class="card" style="padding: 55px;">
            <div class="card-body box-profile">
                <center><strong style="color: #9E9E9E;">! No details found.</strong></center>
            </div>
        </div>


<?php } ?>
