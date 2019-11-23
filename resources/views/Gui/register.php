<!DOCTYPE html>
<html>
<head>
	<title>Register</title>
	<?php include("head.php"); ?>
	<link rel="stylesheet" type="text/css" href="css/register.css">
</head>
<body>
	<header>
		<?php include("header.php");?>
	</header>
	<div class="wrapper">
		<div class="row">
			<div class="sm-col-span-12 lg-col-span-4 content">
				<div class="sm-col-span-6 nav-left">
					<div class="nav-intro-left">
						<div class="nav-intro-img">
							<img src="./Images/tenlua.jpg">
						</div>
						<div class="introduce">
							<h2>Welcom to DLD!</h2>
							<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s,</p>
						</div>
						<div class="link-login">
							<a href="login.html">Đăng nhập</a>
						</div>
					</div>
				</div>
				<div class="sm-col-span-6 lg-col-span-4 register-wrapper">
					<h2>Đăng Ký</h2>
					<p>Đăng ký ngay hôm nay đễ nhận ưu đãi các khóa học miễn phí từ DLD</p>
					<form action="" method="POST" class="form-register clear-fix">
						<div class="form-group sm-col-span-12 lg-col-span-4">
							<label>
								<p>Họ tên</p>
							</label>
							<input type="text" name="name" placeholder="Nguyễn Văn A">
						</div>
						<div class="form-group sm-col-span-12 lg-col-span-4">
							<label>
								<p>Email</p>
							</label>
							<input type="email" name="email" placeholder="example@gmail.com">
						</div>
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
						<div class="form-group sm-col-span-12 lg-col-span-4">
							<label>
								<p>Ngày sinh</p>
							</label>
							<input type="date" name="date">
						</div>
						<div class="form-group sm-col-span-12 lg-col-span-4">
							<label>
								<p>Địa chỉ</p>
							</label>
							<input type="text" name="adress" placeholder="Tỉnh/Thành phố">
						</div>
						<div class="form-group sm-col-span-12 lg-col-span-4">
							<label>
								<p>Số điện thoại</p>
							</label>
							<input type="tel" name="phone" placeholder="0123456789">
						</div>
						<div class="btn-group sm-col-span-12 lg-col-span-4">
							<div class="btn-login sm-col-span-6 lg-col-span-2">
								<button type="submit">Đăng Ký</button>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
	<?php include("footer.php");?>	
</body>
</html>