<?php

include_once "C:/xampp/apps/project/bootstrap.php";

use CT275\Project\Session;
use CT275\Project\Adminlogin;

?>

<?php
	$adminlogin = new Adminlogin($PDO);
	if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit'])) {
		$adminUser = $_POST['adminUser']; 
		$adminPass = md5($_POST['adminPass']);
		$login_check = $adminlogin->login_admin($adminUser,$adminPass);
	}
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QUẢN LÍ BÁNH</title>
    <link rel="stylesheet" type="text/css" href="css/style.css" media="screen" />
</head>
<body class="container-fluid">
	<div class="container">
		<div class="screen">
			<div class="screen__content">
				<form class="login" method="POST">
					<?php
						if(isset($login_check)) {
							echo $login_check;
						}
					?>
					<div class="login__field">
						
						<i class="login__icon fas fa-user"></i>
						<input type="text" name="adminUser" class="login__input" placeholder="Tài Khoản">
					</div>
					
					<div class="login__field">
						<i class="login__icon fas fa-lock"></i>
						<input type="password" name="adminPass" class="login__input" placeholder="Mật Khẩu">
					</div>

					<button type="submit" value="Đăng nhập" name="submit" class="button login__submit">	
						<i class="button__icon fas fa-chevron-right" value="Đăng nhập"></i>
					</button>				
				</form>
			</div>

			<div class="screen__background">
				<span class="screen__background__shape screen__background__shape4"></span>
				<span class="screen__background__shape screen__background__shape3"></span>		
				<span class="screen__background__shape screen__background__shape2"></span>
				<span class="screen__background__shape screen__background__shape1"></span>
			</div>	

		</div>
	</div>
	
</body>
</html>

