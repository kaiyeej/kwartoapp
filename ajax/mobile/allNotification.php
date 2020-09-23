<?php
header("Access-Control-Allow-Origin: *");
require_once '../../core/config.php';
$user_id = $_POST['user_id'];
$id = $_POST['id'];

if($id == "all"){
    $query = "";
}else{
    $query = "AND id ='$id'";
}

?>
<table class="table table-hover" style="font-size: 12px;">
  <tbody>
<?php
    $fetchData = $mysqli_connect->query("SELECT * FROM tbl_notifications WHERE user_id='$user_id' $query");
    $count = 1;
    while($row = $fetchData->fetch_array()){
        $mysqli_connect->query("UPDATE tbl_notifications SET status='1' WHERE id='$row[0]'");
?>
        <tr>
            <td><?= $count++ ?></td>
            <td><?= $row['message'] ?></td>
            <td><?= date('M d, Y h:m',strtotime( $row["date_added"])) ?></td>
            <td><?= getHotel($row['hotel_id']) ?></td>
        </tr>
<?php } ?>
  </tbody>
</table>