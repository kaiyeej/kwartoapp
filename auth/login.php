<?php
require_once '../core/config.php';

if(isset($_SESSION['user_id'])){
    if($_SESSION['user_type'] != "C"){
        header("Location: ../index.php");
        exit;
    }else{
        header("Location: ../user/index.php");
        exit;
    }
    
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title>Kwarto App</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
<!--===============================================================================================-->	
	<link rel="icon" type="image/png" href="images/icons/favicon.ico"/>
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/bootstrap/css/bootstrap.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="fonts/font-awesome-4.7.0/css/font-awesome.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="fonts/Linearicons-Free-v1.0.0/icon-font.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/animate/animate.css">
<!--===============================================================================================-->	
	<link rel="stylesheet" type="text/css" href="vendor/css-hamburgers/hamburgers.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/select2/select2.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="css/util.css">
	<link rel="stylesheet" type="text/css" href="css/main.css">
<!--===============================================================================================-->
</head>
<body>
	
	<div class="limiter">
		<div class="container-login100" style="background-image: url('images/img-01.jpg');">
			<div class="wrap-login100 p-t-190 p-b-30">
				<form action="" method="POST" id='frm_login' class="login100-form validate-form">
					
					<span class="login100-form-title p-t-20 p-b-45">
						Kwarto App
					</span>
                    <div class="wrap-input100 validate-input m-b-10" data-validate = "Username is required">
                        <input class="input100" type="text" autocomplete="off" name="userlogin" id="userlogin" placeholder="Username">
                        <span class="focus-input100"></span>
                        <span class="symbol-input100">
                            <i class="fa fa-user"></i>
                        </span>
                    </div>
                    <div class="wrap-input100 validate-input m-b-10" data-validate = "Password is required">
                        <input class="input100" type="password" autocomplete="off" name="userpassword" id="userpassword" placeholder="Password">
                        <span class="focus-input100"></span>
                        <span class="symbol-input100">
                            <i class="fa fa-lock"></i>
                        </span>
                    </div>
                    <div class="container-login100-form-btn p-t-10">
                        <button class="login100-form-btn">
                            Login
                        </button>
                    </div>
				</form>
			</div>
		</div>
	</div>

<!--===============================================================================================-->	
	<script src="vendor/jquery/jquery-3.2.1.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/bootstrap/js/popper.js"></script>
	<script src="vendor/bootstrap/js/bootstrap.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/select2/select2.min.js"></script>
<!--===============================================================================================-->
	<script src="js/main.js"></script>

</body>
</html>

<script type="text/javascript">

$("#frm_login").submit(function(e){
    e.preventDefault();

    var userlogin = $("#userlogin").val();
    var userpassword = $("#userpassword").val();

    $("#btn_login").prop("disabled", true);
    $("#btn_login").html("<span class='fa fa-spin fa-spinner'></span> Logging in ...");
    $.ajax({
        type:"POST",
        url:"../core/login.php",
        data:{
            userlogin:userlogin,
            userpassword:userpassword
        },
        success:function(data){
            if(data == 1){
                
                window.location = '../index.php';
            }else{
                alert(data);
            }

            $("#btn_login").prop("disabled", false);
            $("#btn_login").html("<span class='small-circle'><i class='fa fa-caret-right'></i></span><small>Sign In</small>");
        }
    });
});
</script>