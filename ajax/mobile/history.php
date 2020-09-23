<?php
header("Access-Control-Allow-Origin: *");
require_once '../../core/config.php';
$user_id = $_POST['user_id'];
?>
<table class="table table-hover" style="font-size: 12px;">
  <tbody>
<?php
    $fetchData = $mysqli_connect->query("SELECT * FROM tbl_reservation WHERE customer_id='$user_id' AND status!='S'");
    $count = 1;
    while($row = $fetchData->fetch_array()){
      $sumTotal = $mysqli_connect->query("SELECT sum(amount) FROM tbl_reservation_details WHERE ref_number='$row[ref_number]'");
	    $total = $sumTotal->fetch_array();
?>
        <tr onclick="window.location='reservation_details.html?id=<?= $row[0] ?>'">
            <td><?= $count++ ?></td>
            <td><?= $row['ref_number'] ?></td>
            <td><?= date('M d',strtotime( $row["start_date"]))."-".date('M d, Y',strtotime( $row["end_date"])) ?></td>
            <td>&#8369;<?= number_format($total[0],2) ?></td>
        </tr>
<?php }

      if($count <= 1){ ?>
        <tr onclick="window.location='reservation_details.html?id=<?= $row[0] ?>'">
            <td colspan="4" style="text-align:center;font-size: 20px;color: #9E9E9E;">! No details found.</td>
        </tr>
  <?php  } ?>
  </tbody>
</table>