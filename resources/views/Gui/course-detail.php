<!DOCTYPE html>
<html>
<head>
	<?php include("head.php"); ?>
	<link rel="stylesheet" type="text/css" href="css/course-detail.css">
</head>
<body>
	<header><?php include("header.php");?></header>
	<div class="wrapper">
		<div class="row">
			<nav>
				<ul class="breadcrumb clear-fix">
					<li><a href="#"><i class="fas fa-home"></i> Trang chủ</a></li>
					<li><a href="#">Khóa học</a></li>
					<li>English</li>
				</ul>
			</nav>
			
			<div class="sm-col-span-8 lg-col-span-4 content">
				<div class="course-content-wr">
					<h1 class="course-title-wr">English</h1>
					<p class="course-intro">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.</p>
					<div class="course-teacher">
						Giáo viên: <a href="#">Nguyễn Văn A</a>
					</div>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="sm-col-span-12 lg-col-span-4 content">
				<div class="video-content">
					<video controls>
						<source src="" type="video/mp4">
						<source src="" type="video/ogg">
					</video>
					<div class="menu-uner-v">
						<nav>
							<ul>
								<li class="bookmark"><a href="#descript">Mô tả khóa học</a></li>
								<li class="bookmark"><a href="#lessons">Bài giảng miễn phí</a></li>
								<li class="bookmark"><a href="#teacher">Giáo viên giảng dạy</a></li>
								<li class="bookmark"><a href="#comment">Đánh giá</a></li>
							</ul>
						</nav>
					</div>
				</div>
				<div class="course-detail">
					<div class="course-t">
						<p class="course-hp"><span>600.000 </span>đồng</p>
						<div class="course-buy">
							<a href="#">Đăng ký ngay</a>
						</div>
						<div class="course-free">
							<a href="#lessons">Học thử miễn phí</a>
						</div>
					</div>
					<div class="course-m">
						<nav>
							<ul class="clear-fix">
								<li class="course-m-sec">
									<h3>Mục tiêu khóa học</h3>
									<ul>
										<li>Lorem Ipsum is simply dummy text of the printing and typesetting industry. </li>
									</ul>
								</li>
								<li class="course-m-sec">
									<h3>Cấu trúc khóa học</h3>
									<ul class="child clear-fix">
										<li>30 bài học</li>
										<li>4 kỹ năng</li>
									</ul>
								</li>
							</ul>
						</nav>
					</div>
				</div>
			</div>
		</div>
		<div class="row" style="border-top: 1px solid #f1f1f1">
			<div class="sm-col-span-8 lg-col-span-4">
				<div class="desc-wr">
					<h3 id="descript">Mô tả khóa học</h3>
					<div class="coures-description">
						<div class="des-techer" id="teacher" >
							<h3>Giáo viên</h3>
							Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.
						</div>
						<div class="des-re">
							<h3>Yêu cầu khóa học</h3>
							Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.
						</div>
						<div class="des-per">
							<h3>Đối tượng</h3>
							Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.
						</div>
					</div>
					<div class="course-struct">
						<div class="course-st-head">
							<div class="course-st-title" id="lessons">
								LESSONS
							</div>
						</div>
						<div class="course-st-b">
							<div class="course-st-row">
								<div class="st-less"><b>Bài 01 </b></div>
								<div class="st-name">Lorem Ipsum is simply dummy text of the printing and typesetting industry.</div>
								<div class="st-cr-test">
									<div class="link-test">
										<a href="course-content.php">Free</a>
									</div>
								</div>
							</div>
							<div class="course-st-row">
								<div class="st-less"><b>Bài 02 </b></div>
								<div class="st-name">Lorem Ipsum is simply dummy text of the.</div>
							</div>
							<div class="course-st-row">
								<div class="st-less"><b>Bài 03 </b></div>
								<div class="st-name">Lorem Ipsum is simply dummy text of the printing and typesetting.</div>
							</div>
							<div class="course-st-row">
								<div class="st-less"><b>Bài 04 </b></div>
								<div class="st-name">Lorem Ipsum is simply dummy text of the printing and typesetting.</div>
							</div>
						</div>
					</div>
					<div class="comment">
						<form method="POST" action="" id="form-c">
							<h3 id="comment">Bình luận</h3>
							<textarea name="comment" placeholder="Mời bạn để lại bình luận..."></textarea>
							<div class="btn-group">
								<button type="submit">Gửi</button>
							</div>
						</form>
						<!-----------------comment of student--------------------------->
						<div class="comments-history">
							<ul class="comments-history-qa clear-fix">
								<li>
									<div class="comment-his-ac">
										<div class="comment-acc">
											<span>Minh</span>
										</div>
										<div class="comment-time">
											<span>1:00</span> Ngày <span>1/1/1970</span>
										</div>
										<div class="comment-ques">
											Lorem Ipsum is simply dummy text of the printing and typesetting industry.
										</div>
										<div class="comment-rep-links">
											<a href="#">Trả lời</a>
											<a href="#">Xóa bình luận</a>
										</div>
									</div>
									<ul class="comments-history-answer">
										<li><div class="comment-his-ac">
											<div class="comment-acc">
												<span>DLD.com</span>
											</div>
											<div class="comment-time">
												<span>1:00</span> Ngày <span>1/1/1970</span>
											</div>
											<div class="comment-ques">
												Lorem Ipsum is simply dummy text of the printing and typesetting industry.
											</div>
										</div></li>
									</ul>
								</li>
								<li>
									<div class="comment-his-ac">
										<div class="comment-acc">
											<span>Minh</span>
										</div>
										<div class="comment-time">
											<span>1:00</span> Ngày <span>1/1/1970</span>
										</div>
										<div class="comment-ques">
											Lorem Ipsum is simply dummy text of the printing and typesetting industry.
										</div>
										<div class="comment-rep-links">
											<a href="#">Trả lời</a>
											<a href="#">Xóa bình luận</a>
										</div>
									</div>
								</li>
							</ul>
						</div>
					</div>
				</div>
			</div>
			<div class="sm-col-span-4 md-col-span-3 lg-col-span-4">
				<div class="course-ref">
					<h3>Khóa học liên quan</h3>
					<div class="course-ref-content">
						<div class="course-img">
							<a href="course-detail.html"><img src="./Images/banner-1.png"></a>
						</div>
						<div class="course-c">
							<p class="course-title">English Lorem Ipsum is simply - <span>Nguyễn Văn A</span></p>
							<p class="course-price"><span>2.000.000</span></p>
							<a href="#">learn more</a>
						</div>
					</div>
					<div class="course-ref-content">
						<div class="course-img">
							<a href="#"><img src="./Images/banner-1.png"></a>
						</div>
						<div class="course-c">
							<p class="course-title">English - <span>Nguyễn Văn A</span></p>
							<p class="course-price"><span>2.000.000</span></p>
						</div>
					</div>
					<div class="course-ref-content">
						<div class="course-img">
							<a href="#"><img src="./Images/banner-1.png"></a>
						</div>
						<div class="course-c">
							<p class="course-title">English - <span>Nguyễn Văn A</span></p>
							<p class="course-price"><span>2.000.000</span></p>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
<?php include("footer.php");?>

<!----bookmark----->
<script>
	$('.bookmark').click(function(){
		if($(this).hasClass('menu-uner-visited')) {
			$(this).removeClass('menu-uner-visited');
		} else {
			$('.menu-uner-visited').removeClass('menu-uner-visited');
			$(this).addClass('menu-uner-visited');
		}
	});
</script>
</body>
</html>