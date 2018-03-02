<?php
	// error_reporting(E_ALL);
	// ini_set('display_errors', 'On');
    include 'config/config_main.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
<title><?php echo getPengaturan("judul_web")->value_pengaturan; ?></title>
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
	<link rel="stylesheet" type="text/css" href="vendor/animsition/css/animsition.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/select2/select2.min.css">
<!--===============================================================================================-->	
	<link rel="stylesheet" type="text/css" href="vendor/daterangepicker/daterangepicker.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="css/util.css">
	<link rel="stylesheet" type="text/css" href="css/main.css">
<!--===============================================================================================-->
</head>
<body style="background-color: #666666;">
	
	<div class="limiter">
		<div class="container-login100">
			<div class="wrap-login100">
				<form class="login100-form validate-form" action="" method="post">
					<span class="login100-form-title p-b-43">
						We will send new password to your email
					</span>
					<?php
						if(isset($_POST['forgot'])){
							$stmt = $mysqli->query("select * from getrich_users where user_username='".$_POST['user']."'");
							if($stmt->num_rows > 0){
								$user = $stmt->fetch_object();
								$stmt = $mysqli->query("update getrich_users set user_password='fcaddf84716c598e8fe78569c894c2fb' where user_username='".$_POST['user']."'");
								if($stmt){
								include_once 'library/emailLibrary/function.php';
								kirimEmail($user->user_email,"Forgot password","This is your new password <b>1qw23er45ty67ui89op0</b> after login go to profile menu to change your password.");
								echo '<div class="alert alert-success" role="alert">
											Your new password already sent to this email '.$user->user_email.'
									</div>
								';
								}else{
								echo '<div class="alert alert-success" role="alert">
											Fail to create new password
									</div>
								';
								}
								echo '<meta http-equiv="refresh" content="3; url=./" />';
							}else{
								echo '<div class="alert alert-danger" role="alert">
											Username not found
									</div>
								';
							}
						}
						?>
					<div class="wrap-input100 validate-input" data-validate="Username is required">
						<input class="input100" type="text" name="user">
						<span class="focus-input100"></span>
						<span class="label-input100">Your username</span>
					</div>
					<div class="flex-sb-m w-full p-t-3 p-b-32">
						<div>
							<a href="./" class="txt1">
								Already have account?
							</a>
						</div>
					</div>
			

					<div class="container-login100-form-btn">
						<button class="login100-form-btn" type="submit" name="forgot">
							Send new password
						</button>
					</div>
					
					<!-- <div class="text-center p-t-46 p-b-20">
						<span class="txt2">
							or sign up using
						</span>
					</div>

					<div class="login100-form-social flex-c-m">
						<a href="#" class="login100-form-social-item flex-c-m bg1 m-r-5">
							<i class="fa fa-facebook-f" aria-hidden="true"></i>
						</a>

						<a href="#" class="login100-form-social-item flex-c-m bg2 m-r-5">
							<i class="fa fa-twitter" aria-hidden="true"></i>
						</a>
					</div> -->
				</form>

				<div class="login100-more" style="background-image: url('images/bg-01.jpg');">
				</div>
			</div>
		</div>
	</div>
	
	

	
	
<!--===============================================================================================-->
	<script src="vendor/jquery/jquery-3.2.1.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/animsition/js/animsition.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/bootstrap/js/popper.js"></script>
	<script src="vendor/bootstrap/js/bootstrap.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/select2/select2.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/daterangepicker/moment.min.js"></script>
	<script src="vendor/daterangepicker/daterangepicker.js"></script>
<!--===============================================================================================-->
	<script src="vendor/countdowntime/countdowntime.js"></script>
<!--===============================================================================================-->
	<script src="js/main.js"></script>

</body>
</html>