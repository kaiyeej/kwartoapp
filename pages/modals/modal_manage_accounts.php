
  <div class="modal" id="modalManageAccount">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Manage Account</h5>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <form action="" method='POST' id='frm_manage_account'>	
        <div class="modal-body">
          <div class="row">
            <div class="col-md-12">
              <input type="hidden" readonly class="form-control" id="type" name="type">
              <input type="hidden" readonly class="form-control" id="user_id" name="user_id">
              <div id="div_hotel" class="form-group" style="margin-bottom: 0rem;padding-bottom: 0px;">
              Hotel:
                <select class="form-control" id="hotel_id" name="hotel_id" required>
                        <option value="">Please Select:</option>
                      <?php
                          $fetchHotel = $mysqli_connect->query("SELECT * FROM tbl_hotels ORDER by hotel_name DESC");
                          while($rowHotel = $fetchHotel->fetch_array()){ ?>
                            <option value='<?= $rowHotel['hotel_id'] ?>'><?= $rowHotel['hotel_name'] ?></option>
                      <?php } ?>
                </select>
              </div>
              <div class="form-group" style="margin-bottom: 0rem;padding-bottom: 0px;">
              Name:
                <input type="text" autocomplete="off" class="form-control" id="name" name="name" required>
              </div>
              <div class="form-group" style="margin-bottom: 0rem;padding-bottom: 0px;">
              Address:
                <textarea class="form-control" autocomplete="off" id="address" name="address" required></textarea>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group" style="margin-bottom: 0rem;padding-bottom: 0px;">
              Contact #:
                <input type="text" autocomplete="off" class="form-control" id="contact_number" name="contact_number" required>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group" style="margin-bottom: 0rem;padding-bottom: 0px;">
              Email:
                <input type="email" autocomplete="off" class="form-control" id="email" name="email" required>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group" style="margin-bottom: 0rem;padding-bottom: 0px;">
              Username:
                <input type="text" autocomplete="off" class="form-control" id="username" name="username" required>
              </div>
            </div>
            <div class="col-md-6" id="div_pass">
              <div class="form-group" style="margin-bottom: 0rem;padding-bottom: 0px;">
              Password:
                <input type="text" autocomplete="off" class="form-control" id="password" name="password" required>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" id="btn_add" class="btn btn-primary btn-link btn-sm"><i class="material-icons">check</i> Save Entry</button>
          <button type="button" data-dismiss="modal" class="btn btn-danger btn-link btn-sm"><i class="material-icons">close</i> Close</button>
        </div>
        </form>
      </div>
    </div>
  </div>