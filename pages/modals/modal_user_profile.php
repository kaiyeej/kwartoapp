<div class="modal" id="modalUserProfile">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Change Password</h5>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col-md-12">
              <div class="form-group" style="margin-bottom: 0rem;padding-bottom: 0px;">
              Old Password:
                <input type="password" autocomplete="off" class="form-control" id="old_password" name="old_password" required>
              </div>
            </div>
            <div class="col-md-12">
              <div class="form-group" style="margin-bottom: 0rem;padding-bottom: 0px;">
                <input type="password" autocomplete="off" class="form-control" id="new_password" name="new_password" required>
              <div class="form-group" style="margin-bottom: 0rem;padding-bottom: 0px;">
                <input type="password" autocomplete="off" class="form-control" id="confirm_password" name="confirm_password" required>
        </div>
        <div class="modal-footer">
          <button type="button" id="btn_pass" onclick="updatePassword()" id="btn_save" class="btn btn-primary btn-link btn-sm"><i class='material-icons'>check</i> Save Entry</button>
          <button type="button" data-dismiss="modal" class="btn btn-danger btn-link btn-sm"><i class="material-icons">close</i> Close</button>
        </div>
      </div>
    </div>
  </div>