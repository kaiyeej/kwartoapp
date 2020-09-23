<style>
img{
  width: 460px;
}
</style>
<div class="modal" id="modalHotelLogo">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Upload</h5>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col-md-12">
            <div class="fileinput fileinput-new text-center" data-provides="fileinput">
            <form id="frm_room_img" action="" method="POST">
              <input type="hidden" id="room_id_img" name="room_id_img" readonly>
              <div id="div_logo" class="fileinput-new thumbnail img-raised">
              </div>
              <div class="fileinput-preview fileinput-exists thumbnail img-raised"></div>
              <div>
              <span class="btn btn-raised btn-round btn-rose btn-file">
              <span class="fileinput-new">Select image</span>
              <span class="fileinput-exists">Change</span>
                <input type="file" id="file" name="file"/>
              </span>
              <a href="javascript:;" class="btn btn-danger btn-round fileinput-exists" data-dismiss="fileinput">
                <i class="fa fa-times"></i> Remove
              </a>
              <button type="submit" class="btn btn-primary btn-round fileinput-exists"><span class="fa fa-upload"></span> UPLOAD</button>
            </form>
            </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" id="btn_pass" onclick="updatePassword()" id="btn_save" class="btn btn-primary btn-link btn-sm"><i class='material-icons'>check</i> Save Entry</button>
          <button type="button" data-dismiss="modal" class="btn btn-danger btn-link btn-sm"><i class="material-icons">close</i> Close</button>
        </div>
      </div>
    </div>
  </div>