<div class="modal" id="modalManageBooking">
    <div class="modal-dialog  modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Manage Booking</h5>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <form action="" method='POST' id='frm_add_booking'>	
        <div class="modal-body">
          <div class="row">
            <input type="hidden" readonly class="form-control" id="type" name="type">
            <input type="hidden" readonly class="form-control" id="reservation_id" name="reservation_id">
            <div class="col-md-12">
              <strong style="font-size: 20px;">Ref #: <span style="color:#607d8b;" id="span_ref"></span></strong>
              <input type="hidden" readonly id="ref_number" name="ref_number">
            </div>
            <div class="col-md-6">
               <div class="form-group" style="margin-bottom: 0rem;padding-bottom: 0px;">
               Customer type:
                <select id="customer_type" name="customer_type" onchange="getCustomer()" class="form-control" required>
                    <option value="1">Walk-in</option>
                    <option value="0">Existing Customer</option>
                </select>
              </div>
            </div>
            <div class="col-md-6">
               <div class="form-group" id="div_customer" style="margin-bottom: 0rem;padding-bottom: 0px;">
               Customer:
                <input type="text" class="form-control" id="customer_id" autocomplete="off" name="customer_id" required>
              </div>
            </div>
            <div class="col-md-6">
               <div class="form-group" style="margin-bottom: 0rem;padding-bottom: 0px;">
               Date of Arrival:
                <input type="text" class="form-control datetimepicker" autocomplete="off" onchange="getRoom()"  id="start_date" name="start_date" required>
              </div>
            </div>
            <div class="col-md-6">
               <div class="form-group" style="margin-bottom: 0rem;padding-bottom: 0px;">
               Date of Departure:
                <input type="text" class="form-control datetimepicker" autocomplete="off" onchange="getRoom()" id="end_date" name="end_date" required>
              </div>
            </div>
            <div class="col-md-6 div_room_header">
              <div class="form-group" style="margin-bottom: 0rem;padding-bottom: 0px;">
              Room Type:
                <select id="type_id" name="type_id" class="form-control" onchange="getRoom()" required>
                    <option value="">Please Select:</option>
                    <?php
                        $hotel_id = $_SESSION['hotel_id'];
                        $fetchType = $mysqli_connect->query("SELECT * FROM tbl_room_type WHERE hotel_id='$hotel_id' ORDER by capacity ASC");
                        while($typeRow = $fetchType->fetch_array()){ ?>
                            <option value="<?= $typeRow['type_id'] ?>"><?= $typeRow['room_type'] ?></option>
                    <?php } ?>
                </select>
              </div>
            </div>
            <div class="col-md-6 div_room_header">
               <div class="form-group" style="margin-bottom: 0rem;padding-bottom: 0px;">
               Room:
                <select id="room_id" name="room_id" class="form-control" required>
                    <option value="">Please Select:</option>
                </select>
              </div>
            </div>
            <div class="col-md-12 div_room_header">
              <button type="submit" id="btn_save" class="btn btn-primary btn-link btn-sm  pull-right"><i class='material-icons'>check</i> Save Entry</button>
            </div>
          </div>
        </form>
        <form action="" method='POST' id='frm_add_booking_details'>
            <div class="row" id="div_addtional">
                <input type="hidden" readonly id="refNum" name="ref_number">
                <div class="col-md-12">
                    <hr>
                    <h6>Additional Details</h4>
                </div>
                <div class="col-md-6">
                    <div class="form-group" style="margin-bottom: 0rem;padding-bottom: 0px;">
                    Type:
                        <select id="service_type" name="service_type" onchange="getService()" class="form-control" required>
                            <option value="S">Service</option>
                            <option value="R">Room</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <div id="div_service_room" class="form-group" style="margin-bottom: 0rem;padding-bottom: 0px;">
                    Service:
                        <select id="service_id" name="service_id" class="form-control" onchange="sumTotal()" required>
                        <option value="">Please Select:</option>
                        <?php
                            $fetchService2 = $mysqli_connect->query("SELECT * FROM tbl_services WHERE hotel_id='$hotel_id' ORDER by service ASC");
                            while($serRow = $fetchService2->fetch_array()){ ?>
                                <option value="<?= $serRow['service_id'] ?>"><?= $serRow['service'] ?></option>
                        <?php } ?>
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group" id="div_customer" style="margin-bottom: 0rem;padding-bottom: 0px;">
                    Quantity:
                        <input type="number" value="1" onkeyup="sumTotal()" class="form-control" id="qty" name="qty" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group" style="margin-bottom: 0rem;padding-bottom: 0px;padding-top: 28px;">
                        <h6>Amount: <span id="span_total">0.00</span></h6>
                    </div>
                </div>
                <div class="col-md-12">
                  <button type="submit" id="btn_save_details" class="btn btn-primary btn-link btn-sm  pull-right"><i class='material-icons'>check</i> Save Entry</button>
                </div>
            </div>
            </form>
              <div id="div_table" class="row">
                <div class="table-responsive">
                  <div class="col-lg-12" style="background-color:transparent;margin-top:10px;">
                      <table id="dt_booking_details" class="table table-striped table-bordered" style="width:100%">
                        <thead style="padding: 10px;background-color: #607D8B;color: #fff;">
                            <tr>
                                <th><strong></strong></th>
                                <th><strong>#</strong></th>
                                <th><strong>Type</strong></th>
                                <th><strong>Room/Service</strong></th>
                                <th><strong>Quantity</strong></th>
                                <th><strong>Amount</strong></th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                  </div>
                </div>
              </div>
          </div>
      </div>
    </div>
  </div>