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
									<li class="active"><a href="#">Số dư tài khoản</a></li>
									<li><a href="#">Lịch sử đăng ký khóa học</a></li>
									<li><a href="#">Trợ giúp</a></li>
								</ul>
							</nav>
						</div>
						<div class="acc-info-right">
							<div class="accout-surplus">
								Số dư trong tài khoản <span>0</span> VND
							</div>
							<div class="accout-recharge">
								<a href="#">Nạp tiền vào tài khoản</a>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<?php include("footer.php"); ?>
		<script>
			var data = '1';
			$(document).ready(function(){
				$('#test').on("click", function(){
					$.ajax({
						url: "account-surplus.php",
						type: 'GET',
						data: data,
						error: function(){
						},
						success: function(response){
							if(data == 'false'){
								alert('Error');
							}
							$('#wr').empty().append(response);
						}
					});
				});
			})
		</script>
	</body>
</html>