
  <div class="modal" id="modalManageRoomType">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Manage Room</h5>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <form action="" method='POST' id='frm_manage_room_type'>	
        <div class="modal-body">
          <div class="row">
            <div class="col-md-12">
              <input type="hidden" readonly class="form-control" id="type" name="type">
              <input type="hidden" readonly class="form-control" id="type_id" name="type_id">
              <div class="form-group" style="margin-bottom: 0rem;padding-bottom: 0px;">
              Room Type:
                <input type="text" class="form-control" id="room_type" name="room_type" required>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group" style="margin-bottom: 0rem;padding-bottom: 0px;">
              Capacity:
                <select class="form-control" id="capacity" required name="capacity">
                  <option value="">Please Select:</option>
                  <option value="1">1 Adult</option>
                  <option value="2">2 Adults</option>
                  <option value="3">3 Adults</option>
                  <option value="4">Family</option>
                </select>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group" style="margin-bottom: 0rem;padding-bottom: 0px;">
              Rate:
                <input type="number" class="form-control" autocomplete="off" id="room_rate" name="room_rate" step="0.01" required>
              </div>
            </div>
            <div class="col-md-12">
              <div id="div_hotel" class="form-group" style="margin-bottom: 0rem;padding-bottom: 0px;">
              Hotel:
                <select class="form-control" id="hotel_id" autocomplete="off" name="hotel_id">
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
              Description:
                <textarea class="form-control" id="remarks" autocomplete="off" name="remarks"></textarea>
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