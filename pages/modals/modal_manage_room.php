
  <div class="modal" id="modalManageRoom">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Manage Room</h5>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <form action="" method='POST' id='frm_manage_room'>	
        <div class="modal-body">
          <div class="row">
            <div class="col-md-12">
              <input type="hidden" readonly class="form-control" id="type" name="type">
              <input type="hidden" readonly class="form-control" id="room_id" name="room_id">
              <div class="form-group">
                Room:
                <input type="text" class="form-control" autocomplete="off" id="room_name" name="room_name" required>
              </div>
            </div>
            <div id="div_hotel" class="col-md-12">
              <div class="form-group" style="margin-bottom: 0rem;padding-bottom: 0px;">
              Hotel:
                <select class="form-control" required id="hotel_id" name="hotel_id">
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
                <textarea class="form-control" id="room_description" autocomplete="off" name="room_description" required></textarea>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group" style="margin-bottom: 0rem;padding-bottom: 0px;">
              Room Type:
                <select class="form-control" id="room_type" name="room_type" required>
                    <option value="">Please Select:</option>
                <?php
                    $fetchRoom = $mysqli_connect->query("SELECT * FROM tbl_room_type ORDER by room_type DESC");
                    while($roomRow = $fetchRoom->fetch_array()){ ?>
                        <option value="<?= $roomRow['type_id']; ?>"><?= $roomRow['room_type']; ?></option>
                <?php } ?>
                </select>
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