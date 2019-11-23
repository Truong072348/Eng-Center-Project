<!DOCTYPE html>
<html>
	<head>
		<title>Account</title>
		<?php include("head.php"); ?>
		<link rel="stylesheet" type="text/css" href="css/account.css">
	</head>
	<body>
		<header>
			<?php include("header.php");?>
		</header>
		<div class="wrapper">
			<?php include("account-banner.php");?>
			<div class="row">
				<div class="sm-col-span-12 lg-col-span-4">
					<div class="acc-func-wr">
						<div class="acc-func-left">
							<nav>
								<ul class="ac-func-menu-l">
									<li><a href="#">Cập nhật thông tin</a></li>
									<li class="active"><a href="#">Thay đổi mật khẩu</a></li>
									<li><a href="#">Trợ giúp</a></li>
								</ul>
							</nav>
						</div>
						<div class="acc-info-right">
							<div class="change-pass">
								<form action="" method="POST" class="form-register clear-fix">
									<h3>Cập nhật mật khẩu</h3>
									<div class="form-group sm-col-span-12 lg-col-span-4">
										<label>
											<p>Nhập mật khẩu hiên tại</p>
										</label>
										<input type="password" id="pass">
									</div>
									<div class="form-group sm-col-span-12 lg-col-span-4">
										<label>
											<p>Mật khẩu mới</p>
										</label>
										<input type="password" id="newpass">
									</div>
									<div class="form-group sm-col-span-12 lg-col-span-4">
										<label>
											<p>Xác nhận lại mật khẩu</p>
										</label>
										<input type="password" id="rNewpass">
									</div>
									<div class="btn-group sm-col-span-12 lg-col-span-4">
										<div class="btn-login">
											<button type="button" id="submit-pass">Xác nhận</button>
										</div>
									</div>
								</form>
							</div>
						</div>
					</div>
				</div>
				
			</div>
		</div>
		<?php include("footer.php"); ?>
		
	</body>
</html>