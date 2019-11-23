<!DOCTYPE html>
<html>
<head>
	<title>Login</title>
	<?php include("head.php"); ?>
	
	<link rel="stylesheet" type="text/css" href="css/login.css">
</head>
<body>
	<header>
		<?php include("header.php");?>
	</header>
	<div class="wrapper">
		<div class="row">
			<div class="sm-col-span-12 lg-col-span-4 col-span-3 content">
				<div class="sm-col-span-6 lg-col-span-4 form">
					<h2>Đăng nhập</h2>
					<div class="socially">
						<a href="#" class="facebook social"><i class="fab fa-facebook-f"></i></a>
						<a href="#" class="google social"><i class="fab fa-google"></i></a>
						<a href="#" class="twitter social"><i class="fab fa-twitter"></i></a>
					</div>
					<form action="" method="POST" class="form-login">
						<div class="form-group sm-col-span-12 lg-col-span-4">
							<label>
								<p>Tên đăng nhập</p>
							</label>
							<input type="text" name="username">
						</div>
						<div class="form-group sm-col-span-12 lg-col-span-4">
							<label>
								<p>Mật khẩu</p>
							</label>
							<input type="password" name="password">
						</div>
						<div class="btn-group sm-col-span-12">
							<div class="btn-login sm-col-span-6 lg-col-span-2">
								<button type="submit">Đăng nhập</button>
							</div>
						</div>
						<div class="links sm-col-span-12 lg-col-span-4">
							<a href="#" class="fgpass sm-col-span-12 lg-col-span-4">Quên mật khẩu?</a>
							<span><a href="register.html">Đăng ký </a>nếu chưa có tài khoản</span>
						</div>
					</form>
				</div>
				<div class="sm-col-span-6 intro-right">
					<div class="intro">
						<h2>Hello, Friend!</h2>
						<p>Enter your personal details and start journey with us</p>
					</div>
				</div>
			</div>
		</div>
	</div>
	<?php include("footer.php");?>
</body>
</html>