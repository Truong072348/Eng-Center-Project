<!DOCTYPE html>
<html>
<head>
	<title>Payment</title>
	<?php include("head.php"); ?>
	<link rel="stylesheet" type="text/css" href="css/payment.css">
</head>
<body>
<header>
	<?php include("header.php");?>
</header>
	<div class="wrapper">
		<div class="row">
			<div class="sm-col-span-12 lg-col-span-4">
				<div class="cr-payment-wr">
					<div class="cr-payment-head">
						<div class="progress-bar">
							<div class="progress"></div>
							<div class="step">
								<div class="step-1">
									<span>Chọn khóa học</span>
									<div class="step-icon">1</div>
								</div>
								<div class="step-2">
									<span>Xác nhận</span>
									<div class="step-icon">2</div>
								</div>
								<div class="step-3">
									<span>Thanh toán</span>
									<div class="step-icon">3</div>
								</div>
							</div>
						</div>
						<div class="course-group-tabs">
							<div class="tab-cate">
								<ul class="clear-fix">
									<li class="active"><a href="#">Luyện thi toeic</a></li>
									<li><a href="#">Luyện thi ielts</a></li>
									<li><a href="#">Anh văn căn bản</a></li>
								</ul>
							</div>
						</div>
					</div>
					<div class="cr-payment-body">
						<div class="guides">
							<ul class="guide-tabs clear-fix">
								<li><span><i class="fas fa-book"></i>Khóa học</span></li>
								<li><span><i class="fas fa-edit"></i>Chọn khóa học</span></li>
								<li><span><i class="fas fa-receipt"></i>Mã quà tặng</span></li>
								<li><span><i class="fas fa-user-check"></i>Khóa học sẽ đăng ký</span></li>
							</ul>
						</div>
						<div class="cart clear-fix">
							<div class="cart-tabs tab-1">
								<ul class="clear-fix">
									<li><a href="#">500</a></li>
									<li><a href="#">600</a></li>
									<li><a href="#">700</a></li>
									<li><a href="#">800</a></li>
								</ul>
							</div>
							<div class="cart-tabs tab-2">
								<div class="course-wr">
									<ul class="clear-fix">
										<li>
											<div class="cart-course">
												<div class="cr-course-name">
													English English English English English
												</div>
												<div class="cr-course-price">
													2.000.000
												</div>
												<div class="cr-course-teacher">
													Nguyễn Văn A
												</div>
												<div class="chose">
													<a href="#">Chọn</a>
												</div>
											</div>
										</li>
										<li>
											<div class="cart-course">
												<div class="cr-course-name">
													English English English English English
												</div>
												<div class="cr-course-price">
													2.000.000
												</div>
												<div class="cr-course-teacher">
													Nguyễn Văn A
												</div>
												<div class="chose">
													<a href="#">Chọn</a>
												</div>
											</div>
										</li>
									</ul>
								</div>
							</div>
							<div class="cart-tabs tab-3">
								<form>
									<div class="coupon">
										<label>Nhâp mã quà tặng</label>
										<input type="text" name="coupon" placeholder="Coupon">
									</div>
									<div class="btn-group">
										<button>Nhập mã</button>
									</div>
								</form>
							</div>
							<div class="cart-tabs tab-4">
								<div class="course-wr">
									<ul class="clear-fix">
										<li>
											<div class="cart-item">
												<div class="cr-item-name">
													English English English English English
												</div>
												<div class="cr-item-price">
													2.000.000
												</div>
												<div class="cr-item-teacher">
													Nguyễn Văn A
												</div>
											</div>
										</li>
										<li>
											<div class="cart-item">
												<div class="cr-item-name">
													English
												</div>
												<div class="cr-item-price">
													2.000.000
												</div>
												<div class="cr-item-teacher">
													Nguyễn Văn A
												</div>
											</div>
										</li>
									</ul>
								</div>
								<div class="price-wr">
									<div class="price-total clear-fix">
										<div class="price-label">Học phí</div>
										<div id="price-total">2.000.000</div>
									</div>
									<div class="price-after clear-fix">
										<div class="price-label">Học phí phải đóng</div>
										<div id="price-refund">0</div>
									</div>
									<div class="reg">
										<a href="#">Đăng ký khóa học</a>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<?php include("footer.php");?>
</body>
</html>