<?php

include 'core/config.php';
checkLoginStatus(); 
$page = (isset($_GET['page']) && $_GET['page'] !='') ? $_GET['page'] : '';

$system_date = date('Y-m-d', strtotime(getCurrentDate()));

$hotel_id = $_SESSION['hotel_id'];
$date = getCurrentDate();
$fetchRS = $mysqli_connect->query("SELECT ref_number FROM tbl_reservation WHERE hotel_id='$hotel_id' AND status='S' AND start_date < '$date'");
while($rowRS = $fetchRS->fetch_array()){
	$mysqli_connect->query("UPDATE tbl_reservation SET status='NA' WHERE hotel_id='$hotel_id' AND ref_number='$rowRS[0]'");
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <link rel="apple-touch-icon" sizes="76x76" href="icon.PNG">
  <link rel="icon" type="image/png" href="icon.PNG">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
  <title>
    Kwarto-app
  </title>
  <meta content='width=device-width, initial-scale=1.0, shrink-to-fit=no' name='viewport' />
  <!--     Fonts and icons     -->
  <link rel="stylesheet" type="text/css" href="assets/css/material_icon.css" />
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css">
  <!-- CSS Files -->
  <link href="assets/css/material-dashboard.css?v=2.1.2" rel="stylesheet" />

  
  <!-- Bootstrap -->
  <link href="assets/css/bootstrap.css" rel="stylesheet"/>
  <link href="assets/css/dataTables.bootstrap4.min.css" rel="stylesheet" />
  <link href="assets/css/responsive.bootstrap4.min.css" rel="stylesheet" />

  <!-- Sweetalert -->
  <link rel="stylesheet" href="assets/css/sweetalert.css">
  
  <link rel="stylesheet" href="assets/css/bootstrap-datetimepicker.css">
  
  <!--   Core JS Files   -->
  <script src="assets/js/core/jquery.min.js"></script>
  <script src="assets/js/plugins/jquery-3.5.1.js"></script>
  <link rel="stylesheet" href="assets/css/jasny-bootstrap.min.css">
  <!--  DataTables.net Plugin, full documentation here: https://datatables.net/  -->
  <script src="assets/js/plugins/jquery.dataTables.min.js"></script>
  <script src="assets/js/plugins/dataTables.bootstrap4.min.js"></script>
  <script src="assets/js/plugins/dataTables.responsive.min.js"></script>
  <script src="assets/js/plugins/responsive.bootstrap4.min.js"></script>
  
</head>

<body class="">
  <div class="wrapper ">
    <div class="sidebar" data-color="purple" data-background-color="white" data-image="assets/img/sidebar-1.jpg">
      <!--
        Tip 1: You can change the color of the sidebar using: data-color="purple | azure | green | orange | danger"

        Tip 2: you can also add an image using data-image tag
    -->
      <div class="logo" style="background:#05727f;">
        <a class="simple-text logo-normal"><img src="head_icon.png" style="width:75px;"></a>
      </div>
      <input type="hidden" readonly value="<?= getCurrentDate(); ?>" id="date_today">
      <div class="sidebar-wrapper">
        <?php require "component/sidebar.php" ?>
      </div>
    </div>
    <div class="main-panel">
      <!-- Navbar -->
      <nav class="navbar navbar-expand-lg navbar-transparent navbar-absolute fixed-top ">
        <div class="container-fluid">
          <div class="navbar-wrapper">
            <a class="navbar-brand" href="javascript:;"></a>
          </div>
          <button class="navbar-toggler" type="button" data-toggle="collapse" aria-controls="navigation-index" aria-expanded="false" aria-label="Toggle navigation">
            <span class="sr-only">Toggle navigation</span>
            <span class="navbar-toggler-icon icon-bar"></span>
            <span class="navbar-toggler-icon icon-bar"></span>
            <span class="navbar-toggler-icon icon-bar"></span>
          </button>
          <div class="collapse navbar-collapse justify-content-end">
          </div>
        </div>
      </nav>
      <!-- End Navbar -->  

      <!-- R O U T E S -->
      <?php require_once 'routes/routes.php'; ?>

      <footer class="footer">
        <?php require "component/footer.php" ?>
      </footer>
    </div>
  </div>
  <div class="fixed-plugin">
    <div class="dropdown show-dropdown">
      <a id="fixed_cogs" href="#" data-toggle="dropdown">
        <i class="fa fa-cog fa-2x"> </i>
      </a>
      <ul class="dropdown-menu">
        <li class="header-title"> SETTINGS</li>
      <?php if($_SESSION['user_type'] == "A"){ ?>
        <li class="button-container">
          <a href="index.php?page=hotel-profile" class="btn btn-success btn-block">Hotel Profile</a>
        </li>
      <?php } ?>
        <li class="button-container">
          <a href="index.php?page=user-profile" class="btn btn-success btn-block">User Profile</a>
        </li>
        <li class="button-container">
          <a href="index.php?page=logs" class="btn btn-success btn-block">Logs</a>
        </li>
       
        <li class="button-container">
          <a href="auth/logout.php" class="btn btn-default btn-block">LOG-OUT</a>
        </li>
        
        
      </ul>
    </div>
  </div>

  <!--   Core JS Files   -->
  <script src="assets/js/core/popper.min.js"></script>
  <script src="assets/js/core/bootstrap-material-design.min.js"></script>
  <script src="assets/js/plugins/perfect-scrollbar.jquery.min.js"></script>

  <!-- Plugin for the momentJs  -->
  <script src="assets/js/plugins/moment.min.js"></script>
  <!--  Plugin for the DateTimePicker, full documentation here: https://eonasdan.github.io/bootstrap-datetimepicker/ 
  <script src="assets/js/plugins/bootstrap-datetimepicker.min.js"></script>-->
  
  <script src="assets/js/plugins/date-time-picker.min.js"></script>
  <!--  Plugin for Sweet Alert -->
  <script src="assets/js/plugins/sweetalert2.js"></script>
  <!-- Forms Validations Plugin -->
  <script src="assets/js/plugins/jquery.validate.min.js"></script>
  <!-- Plugin for the Wizard, full documentation here: https://github.com/VinceG/twitter-bootstrap-wizard -->
  <script src="assets/js/plugins/jquery.bootstrap-wizard.js"></script>
  <!--	Plugin for Select, full documentation here: http://silviomoreto.github.io/bootstrap-select -->
  <script src="assets/js/plugins/bootstrap-selectpicker.js"></script>
  <!-- Plugin for Fileupload, full documentation here: http://www.jasny.net/bootstrap/javascript/#fileinput -->
    <script src="assets/js/plugins/jasny-bootstrap.min.js"></script>
  <!-- Control Center for Material Dashboard: parallax effects, scripts for the example pages etc -->
  <script src="assets/js/material-dashboard.js?v=2.1.2" type="text/javascript"></script>
  <!-- Sweetalert -->
  <script src="assets/js/plugins/sweetalert.js"></script>
  <?php require "script.php"; ?>
</body>

</html>