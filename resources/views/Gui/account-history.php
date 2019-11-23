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
								<li><a href="#">Số dư tài khoản</a></li>
								<li class="active"><a href="#">Lịch sử đăng ký khóa học</a></li>
								<li><a href="#">Trợ giúp</a><i class="fas fa-question-circle"></i></li>
							</ul>
						</nav>
					</div>
					<div class="acc-info-right">
						<h3>Thông tin đăng ký khóa học</h3>
	
						<div class="course-register">
							<div class="cr-rg-head">
								<a href="#">English For All</a> <i class="far fa-calendar-alt"></i> Ngày đăng ký: <span>1/1/1970</span>
								<div class="cr-rg-teacher">
									Giáo viên: <a href="#">Nguyễn Văn A</a>
								</div>
								<div class="cr-rg-price">
									Học phí: <span>600.000</span><sup> đồng</sup>
								</div>
							</div>
							<div class="cr-rg-body">
								<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.</p>
							</div>
						</div>
						<div class="course-register">
							<div class="cr-rg-head">
								<a href="#">English For All</a> <i class="far fa-calendar-alt"></i> Ngày đăng ký: <span>1/1/1970</span>
								<div class="cr-rg-teacher">
									Giáo viên: <a href="#">Nguyễn Văn A</a>
								</div>
								<div class="cr-rg-price">
									Học phí: <span>600.000</span><sup> đồng</sup>
								</div>
							</div>
							<div class="cr-rg-body">
								<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.</p>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<?php include("footer.php"); ?>
</body>
</html>