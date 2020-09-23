<?php
require_once '../core/config.php';
?>
<li><a href="./index.html">ALL</a></li>
<?php
    $fetchHotel = $mysqli_connect->query("SELECT * FROM tbl_hotels");
    while($hotelRow = $fetchHotel->fetch_array()){ ?>
        <li><a href="./index.html"><?= $hotelRow['hotel_name']; ?></a></li>
<?php } ?>