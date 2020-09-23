<?php
require_once '../core/config.php';

if(isset($_POST['sales_year'])){
    $sales_year = $_POST['sales_year'];
    $hotel_id = $_SESSION['hotel_id'];
    $total = 0;

    $count = 1;
    while($count <= 12){
        $fetch_sales = $mysqli_connect->query("SELECT sum(amount) from tbl_reservation as r, tbl_reservation_details as rd where r.ref_number=rd.ref_number and r.status='F' and MONTH(r.start_date)='$count' and YEAR(r.start_date)='$sales_year' AND r.hotel_id='$hotel_id'");
        $sales_row = $fetch_sales->fetch_array();

        $sold_sales = $sales_row[0]*1;
        $total += $sold_sales;
        ?>

    <tr>
        <td><?php echo $count; ?></td>
        <td><?php echo date('F', strtotime($sales_year.'-'.$count.'-01')); ?></td>
        <td><?php echo number_format($sold_sales, 2); ?></td>
    </tr>

<?php
    $count++; }
}

?>
<tr>
    <td colspan='2' style='text-align:right;font-size: 20px'>Total</td>
    <td style="font-size: 20px;"><?php echo number_format($total, 2); ?></td>
</tr>