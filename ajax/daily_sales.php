<?php
require_once '../core/config.php';

if(isset($_POST['date'])){
    $date = $_POST['date'];
    $hotel_id = $_SESSION['hotel_id'];
    $total = 0;

    $fetchData = $mysqli_connect->query("SELECT * FROM tbl_reservation WHERE start_date='$date' AND status != 'P' AND hotel_id='$hotel_id'");
    $total = 0;
    $count = 1;
    while($row = $fetchData->fetch_array()){
        $sum_ = $mysqli_connect->query("SELECT sum(amount) FROM tbl_reservation_details WHERE ref_number='$row[ref_number]'");
        $sum = $sum_->fetch_array();
        $total += $sum[0];
        
        if($row['customer_id'] == 0){
            $customer = $row['walk_in'];
        }else{
            $customer = getUSer($row['customer_id']);
        }
        
?>

    <tr>
        <td><?php echo $count++; ?></td>
        <td><?php echo strtoupper($customer); ?></td>
        <td><?php echo number_format($sum[0], 2); ?></td>
    </tr>

<?php }
}

?>
<tr>
    <td colspan='2' style='text-align:right;font-size: 20px'>Total</td>
    <td style="font-size: 20px;"><?php echo number_format($total, 2); ?></td>
</tr>