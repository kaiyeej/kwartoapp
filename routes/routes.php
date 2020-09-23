<?php
	if($page == 'home'){
		if($_SESSION['user_type'] == "A"){
			require view.'homepage.php';
		}else{
			require view.'homepage_super_admin.php';
		}
		
	}else if($page == 'hotels'){
		require view.'hotels.php';
	}else if($page == 'rooms'){
		require view.'rooms.php';
	}else if($page == 'room-type'){
		require view.'room_type.php';
	}else if($page == 'services'){
		require view.'services.php';
	}else if($page == 'logs'){
		require view.'logs.php';
	}else if($page == 'user-profile'){
		require view.'user_profile.php';
	}else if($page == 'hotel-profile'){
		require view.'hotel_profile.php';
	}else if($page == 'accounts'){
		require view.'accounts.php';
	}else if($page == 'booking'){
		require view.'booking.php';
	}else if($page == 'print-invoice'){
		require view.'print/print_invoice.php';
	}else if($page == 'monthly-sales'){
		require view.'monthly_sales.php';
	}else if($page == 'daily-sales'){
		require view.'daily_sales.php';
	}else{
		if(!empty($page) or $page != $page){
			require view.'error.php';
		}else{
			if($_SESSION['user_type'] == "A"){
				require view.'homepage.php';
			}else{
				require view.'homepage_super_admin.php';
			}
		}
	}
	
 ?>
