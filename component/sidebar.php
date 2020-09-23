<ul class="nav">
  <li class="nav-item <?php if(empty($page) OR $page == "homepage"){ echo "active"; } ?>">
    <a class="nav-link" href="./">
      <i class="material-icons">dashboard</i>
      <p>Dashboard</p>
    </a>
  </li>
  <?php if($_SESSION['user_type'] == "S"){ ?>
  <li class="nav-item <?php if($page == "hotels"){ echo "active"; } ?>">
    <a class="nav-link" href="index.php?page=hotels">
      <i class="material-icons">house_siding</i>
      <p>Hotels</p>
    </a>
  </li>
  <?php } ?>
  
  <li class="nav-item <?php if($page == "room-type"){ echo "active"; } ?>">
    <a class="nav-link" href="index.php?page=room-type">
      <i class="material-icons">view_list</i>
      <p>Room Type</p>
    </a>
  </li>
  <li class="nav-item <?php if($page == "rooms"){ echo "active"; } ?>">
    <a class="nav-link" href="index.php?page=rooms">
      <i class="material-icons">hotel</i>
      <p>Rooms</p>
    </a>
  </li>
  <li class="nav-item <?php if($page == "services"){ echo "active"; } ?>">
    <a class="nav-link" href="index.php?page=services">
      <i class="material-icons">room_service</i>
      <p>Services</p>
    </a>
  </li>
  <?php if($_SESSION['user_type'] == "A"){ ?>
  <li class="nav-item <?php if($page == "booking"){ echo "active"; } ?>">
    <a class="nav-link" href="index.php?page=booking">
      <i class="material-icons">pending_actions</i>
      <?php
        $hotel_id = $_SESSION['hotel_id'];
        $fetchPending = $mysqli_connect->query("SELECT count(reservation_id) FROM tbl_reservation WHERE hotel_id='$hotel_id' AND status='P'") or die(mysqli_error());
        $pendingCount = $fetchPending->fetch_array();
      ?>
      <p>Booking <?php if($pendingCount[0] > 0){ echo "<strong style='color:#f44336;'>(".$pendingCount[0].")</strong>"; } ?></p>
    </a>
  </li>
  <?php } ?>
  <li class="nav-item <?php if($page == "accounts"){ echo "active"; } ?>">
    <a class="nav-link" href="index.php?page=accounts">
      <i class="material-icons">group</i>
      <p>Accounts</p>
    </a>
  </li>
  <?php if($_SESSION['user_type'] == "A"){ ?>
  <li class="nav-item <?php if($page == "monthly-sales"){ echo "active"; } ?>">
    <a class="nav-link" href="index.php?page=monthly-sales">
      <i class="material-icons">bar_chart</i>
      <p>Monthly Sales Report</p>
    </a>
  </li>
  <?php } ?>
  <?php if($_SESSION['user_type'] == "A"){ ?>
  <li class="nav-item <?php if($page == "daily-sales"){ echo "active"; } ?>">
    <a class="nav-link" href="index.php?page=daily-sales">
      <i class="material-icons">show_chart</i>
      <p>Daily Sales Report</p>
    </a>
  </li>
  <?php } ?>
  <li class="nav-item active-pro ">
    <a class="nav-link" href="./">
      <p>&copy; Group name 2020</p>
    </a>
  </li>
</ul>