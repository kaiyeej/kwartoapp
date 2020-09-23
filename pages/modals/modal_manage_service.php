<div class="modal" id="modalManageService">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Manage Service</h5>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <form action="" method='POST' id='frm_manage_services'>	
        <div class="modal-body">
          <div class="row">
            <div class="col-md-12">
              <input type="hidden" readonly class="form-control" id="type" name="type">
              <input type="hidden" readonly class="form-control" id="service_id" name="service_id">
              <div class="form-group" style="margin-bottom: 0rem;padding-bottom: 0px;">
              Service:
                <input type="text" autocomplete="off" class="form-control" id="service" name="service" required>
              </div>
            </div>
            <div class="col-md-12">
              <div class="form-group" id="div_hotel" style="margin-bottom: 0rem;padding-bottom: 0px;">
              Hotel:
                <select class="form-control" id="hotel_id" name="hotel_id">
                    <option value="">Please Select:</option>
                <?php
                    $fetchHotel = $mysqli_connect->query("SELECT * FROM tbl_hotels ORDER by hotel_name DESC");
                    while($hotelRow = $fetchHotel->fetch_array()){ ?>
                        <option value="<?= $hotelRow['hotel_id']; ?>"><?= $hotelRow['hotel_name']; ?></option>
                <?php } ?>
                </select>
              </div>
            </div>
            <div class="col-md-12">
              <div class="form-group" style="margin-bottom: 0rem;padding-bottom: 0px;">
              Rate:
                <input type="number" autocomplete="off" class="form-control" id="service_rate" name="service_rate" step="0.01" required>
              </div>
            </div>
            <div class="col-md-12">
              <div class="form-group" style="margin-bottom: 0rem;padding-bottom: 0px;">
              Description:
                <textarea class="form-control" id="service_description" name="service_description"></textarea>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" id="btn_save" class="btn btn-primary btn-link btn-sm"><i class='material-icons'>check</i> Save Entry</button>
          <button type="button" data-dismiss="modal" class="btn btn-danger btn-link btn-sm"><i class="material-icons">close</i> Close</button>
        </div>
        </form>
      </div>
    </div>
  </div>