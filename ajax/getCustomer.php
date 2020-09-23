<?php
require_once '../core/config.php';
$customer_type = $_POST['customer_type'];
$hotel_id = $_SESSION['hotel_id']; ?>
    <label>Customer:</label>

 <?php
        if($customer_type == 1){ ?>
            <input type="text" class="form-control" id="customer_id" name="customer_id" required>
    <?php }else{ ?>
            <select class="form-control" id="customer_id" name="customer_id" required>
            <option value="">Please Select:</option>
            <?php
                $fetchUser = $mysqli_connect->query("SELECT * FROM tbl_users WHERE hotel_id='$hotel_id' AND user_type='C' ORDER by name ASC");
                while($userRow = $fetchUser->fetch_array()){ ?>
                    <option value="<?= $userRow['user_id'] ?>"><?= $userRow['name'] ?></option>
            <?php } ?>
            <select>
    <?php } ?>
