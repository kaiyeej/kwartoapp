<?php
  $hotel_id = $_SESSION['hotel_id'];
  $fecthHotel =  $mysqli_connect->query("SELECT * FROM tbl_hotels WHERE hotel_id='$hotel_id'");
  $hotelRow = $fecthHotel->fetch_array();

  $ref_number = $_GET['ref'];
  $fetchBooking = $mysqli_connect->query("SELECT * FROM tbl_reservation WHERE ref_number='$ref_number'");
  $row = $fetchBooking->fetch_array();

  if($row['customer_id'] == 0){
    $customer = $row['walk_in'];
  }else{
    $customer = getUser($row['customer_id']);
  }

?>

<style>
@media print
{    
    button
    {
        display: none !important;
    }

    #fixed_cogs{
        display: none !important;
    }
}
</style>
<div class="content">
  <div class="container-fluid">
    <button type='button' rel='tooltip' onclick="window.location='index.php?page=booking'" title='Print Invoice' class='btn btn-success btn-link btn-sm'><i class='material-icons'>arrow_back_ios</i> Back</button>
    <button type='button' rel='tooltip' onclick="window.print()" title='Print Invoice' class='btn btn-default btn-link btn-sm'><i class='material-icons'>local_printshop</i> Print</button>
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-body">
            <div class="table-responsive">
              <table style="width:100%;">
                <th style="width:30%;">
                  <?php
                      if(!empty($hotelRow['hotel_img'])){ ?>
                        <img style='width:100px;' class='img-responsive pull-left' src='assets/hotel_img/<?= $hotelRow['hotel_img'] ?>'>
                  <?php } ?>
                </th>
                <th style="width:40%;"></th>
                <th style="text-align: right;style="text-align: right;width:30%;">
                    <h4><?= getHotel($_SESSION['hotel_id']); ?></h4>
                    <p><?= $hotelRow['hotel_address']; ?></p>
                </th>
              </table>
              <br><br><br>
              <div class="col-md-12">
                  <h3>Invoice to:</h3>
              </div>
              <br>
              <div class="col-md-12">
                <table>
                  <tr>
                    <th style="width:70px;"></th>
                    <th style="margin-left: 80px;">Name: </th>
                    <th style="width:50px;"></th>
                    <th><?= strtoupper($customer); ?></th>
                  </tr>
                  <tr>
                    <th style="width:70px;"></th>
                    <th style="margin-left: 80px;">Ref #: </th>
                    <th style="width:50px;"></th>
                    <th><?= $row['ref_number']; ?></th>
                  </tr>
                  <tr>
                    <th style="width:70px;"></th>
                    <th style="margin-left: 80px;">Arrival Date: </th>
                    <th style="width:50px;"></th>
                    <th><?= date('F d, Y',strtotime($row["start_date"])); ?></th>
                  </tr>
                  <tr>
                    <th style="width:70px;"></th>
                    <th style="margin-left: 80px;">Departure Date: </th>
                    <th style="width:50px;"></th>
                    <th><?= date('F d, Y',strtotime($row["end_date"])); ?></th>
                  </tr>
                </table>
              </div>
              <div class="col-md-12" style="padding: 90px;">
                <h6>Summary</h6><br>
                <table class="table">
                    <thead style="background: #B0BEC5;">
                      <tr>
                        <th scope="col">#</th>
                        <th scope="col">Service</th>
                        <th scope="col" style="text-align:right;">Qty</th>
                        <th scope="col" style="text-align:right;">Unit Price</th>
                        <th scope="col" style="text-align:right;" >Total</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                        $fetchDetails = $mysqli_connect->query("SELECT * FROM tbl_reservation_details WHERE ref_number='$ref_number'");
                        $count = 1;
                        $total = 0;
                        while($rowD = $fetchDetails->fetch_array()){
                          if($rowD == "S"){
                            $service = getService($rowD['service_id']);
                          }else{
                            $service = getRoomTYpe(getRoom_type($rowD['room_id']))." (".getRoom($rowD['room_id']).")";
                          }

                          $total += $rowD['amount'];
                      ?>
                          <tr>
                            <td scope="col"><?= $count++; ?></td>
                            <td scope="col"><?= $service; ?></td>
                            <td scope="col" style="text-align:right;"><?= $rowD['qty']; ?></td>
                            <td scope="col" style="text-align:right;"><?= number_format($rowD['amount']/$rowD['qty'],2); ?></td>
                            <td scope="col" style="text-align:right;" ><?= number_format($rowD['amount'],2) ?></td>
                          </tr>
                      <?php } ?>
                    </tbody>
                    <tfoof>
                      <td style="text-align:right;font-size: 25px;color: #607D8B;" scope="col" colspan="4">Total:</td>
                      <td style="text-align:right;font-size: 25px;color: #607D8B;" scope="col"><strong><?= number_format($total,2) ?></strong></td>
                    </tfoof>
                  </table>
                  <br><br><br><br><br>
                  <table style="width:100%;">
                    <th style="width:50%;">
                      Prepared By: <span style="border-bottom:1px solid;padding-left:25px;padding-right:25px;">
                     <?php echo getUser($_SESSION['user_id']);?><span>
                    </th>
                    <th style="width:50%;">
                      <div style="text-align: end;">Customer Signature: <span style="border-bottom:1px solid;padding-left:25px;padding-right:25px;">
                      <strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span></strong></div>
                    </th>
                  </table>

              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>