<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-transparent navbar-absolute fixed-top ">
    <div class="container-fluid">
      <div class="navbar-wrapper">
      </div>
      <button class="navbar-toggler" type="button" data-toggle="collapse" aria-controls="navigation-index" aria-expanded="false" aria-label="Toggle navigation">
        <span class="sr-only">Toggle navigation</span>
        <span class="navbar-toggler-icon icon-bar"></span>
        <span class="navbar-toggler-icon icon-bar"></span>
        <span class="navbar-toggler-icon icon-bar"></span>
      </button>
    </div>
</nav>
  <!-- End Navbar -->
  <div class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-lg-4 col-md-6">
          <div class="card card-stats">
            <div style="height: 85px;" class="card-header card-header-warning card-header-icon">
              <div class="card-icon">
                <i class="material-icons">house_siding</i>
              </div>
              <p class="card-category" style="font-size: 35px;">Hotel</p>
              <h3 class="card-title" style="font-size: 35px;"><?= totalHotel(); ?>
              </h3>
            </div>
            <div class="card-footer">
            </div>
          </div>
        </div>

        <div class="col-lg-4 col-md-6">
          <div class="card card-stats">
            <div style="height: 85px;" class="card-header card-header-primary card-header-icon">
              <div class="card-icon">
                <i class="material-icons">supervisor_account</i>
              </div>
              <p class="card-category" style="font-size: 35px;">User</p>
              <h3 class="card-title" style="font-size: 35px;"><?= totalUser(); ?>
              </h3>
            </div>
            <div class="card-footer">
            </div>
          </div>
        </div>
        
        <div class="col-lg-4 col-md-6">
          <div class="card card-stats">
            <div style="height: 85px;" class="card-header card-header-success card-header-icon">
              <div class="card-icon">
                <i class="material-icons">mobile_friendly</i>
              </div>
              <p class="card-category" style="font-size: 35px;">Mobile User</p>
              <h3 class="card-title" style="font-size: 35px;"><?= totalMobileUser(); ?>
              </h3>
            </div>
            <div class="card-footer">
            </div>
          </div>
        </div>

        <div style="display:none;" class="col-lg-12 col-md-12">
          <div class="card card-stats" style="padding: 15px;">
              <td>
                <label class="input-group-addon"><strong>Start Date:</strong></label>
                <input type="date" class="form-control" id="start_date" value="<?php echo date('Y-m-d', strtotime(getCurrentDate())); ?>" autocomplete='off'>
              </td>
              <td>
                <label class="input-group-addon"><strong>End Date:</strong></label>
                <input type="date" class="form-control" id="end_date" value="<?php echo date('Y-m-d', strtotime(getCurrentDate())); ?>" autocomplete='off'>
              </td>
              <td>
                <div class="input-group" style="padding:3px;padding-top: 23px;">
                  <button class='btn btn-primary btn-xs' onclick="generate_sales_daily_graph()" id='btn_generate'><span class='material-icons'>refresh</span> Generate</button>
                  <button class='btn btn-default btn-xs' onclick="printDiv('container-report')"><span class="material-icons">local_printshop</span> Print </button>
                </div>
              </td>
            </table>
          </div>
        </div>
      </div>
      </div>
    </div>
  </div>

<!-- MODAL START -->
<?php include 'pages/modals/modal_manage_booking.php'; ?>
<!-- MODAL END -->
<script>

$(document).ready(function() {
});

</script>
