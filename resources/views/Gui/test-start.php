<!DOCTYPE html>
<html>
	<head>
		<title>index</title>
		<?php include("head.php"); ?>
		<link rel="stylesheet" type="text/css" href="css/index.css">
		<link rel="stylesheet" type="text/css" href="css/test.css">
	</head>
	<body>
		<header>
			<?php include("header.php");?>
		</header>
		<div class="wrapper">
			<div class="row">
				<div class="sm-col-span-12 lg-col-span-4">
					<nav>
						<ul class="breadcrumb clear-fix">
							<li><a href="#"><i class="fas fa-home"></i> Trang chủ</a></li>
							<li><a href="#">Khóa học</a></li>
							<li><a href="#">English</a></li>
							<li>Test 01</li>
						</ul>
					</nav>
				</div>
			</div>
			<div class="row">
				<div class="sm-col-span-12 lg-col-span-4">
					<div class="content-wr-intro">
						<h3><span>English For All</span></h3>
						<div class="test-info">
							<table class="table">
								<tr>
									<td colspan="2"><div class="ts-info-title">Test 01 Noun</div></td>
								</tr>
								<tr>
									<td>Tổng số câu: </td>
									<td>10 / 10</td>
								</tr>
								<tr>
									<td>Điểm số tối đa: </td>
									<td>10 / 10</td>
								</tr>
								<tr>
									<td>Thời gian làm bài: </td>
									<td>30:00 phút</td>
								</tr>
							</table>
							<div class="start-test">
								<button type="button" id="btn-start">Bắt đầu kiểm tra</button>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<?php include("footer.php");?>
		<!-----Jquery simple slider plugin-------->
		<script src="javascript/jquery.simpleslider.js"></script>
		<script src="javascript/trans.js"></script>
		<!------jquery Event------->
		<script src="javascript/index.js"></script>
		<script src="javascript/countdown-test.js"></script>
	</body>
</html>