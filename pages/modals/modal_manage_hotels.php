
  <div class="modal" id="modalManageHotel">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Manage Hotel</h5>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <form action="" method='POST' id='frm_manage_hotel'>	
        <div class="modal-body">
          <div class="row">
            <div class="col-md-12">
              <input type="hidden" readonly class="form-control" id="type" name="type">
              <input type="hidden" readonly class="form-control" id="hotel_id" name="hotel_id">
              <div class="form-group" style="margin-bottom: 0rem;padding-bottom: 0px;">
              Hotel:
                <input type="text" class="form-control" autocomplete="off" id="hotel_name" name="hotel_name" required>
              </div>
              <div class="form-group" style="margin-bottom: 0rem;padding-bottom: 0px;">
              Address:
                <textarea class="form-control" id="hotel_address" name="hotel_address" required></textarea>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group" style="margin-bottom: 0rem;padding-bottom: 0px;">
              Contact #:
                <input type="text" class="form-control" autocomplete="off" id="hotel_contact_number" name="hotel_contact_number" required>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group" style="margin-bottom: 0rem;padding-bottom: 0px;">
              Email:
                <input type="email" class="form-control" autocomplete="off" id="hotel_email" name="hotel_email" required>
              </div>
            </div>
            <div class="col-md-12">
              <div class="form-group" style="margin-bottom: 0rem;padding-bottom: 0px;">
              Description:
                <textarea class="form-control" id="hotel_description" autocomplete="off" name="hotel_description"></textarea>
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