<!DOCTYPE html>
<html>
<head>
	<title>Content</title>
	<?php include("head.php"); ?>
	<link rel="stylesheet" type="text/css" href="css/course-content.css">
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
						<li>Bài 01</li>
					</ul>
				</nav>
			</div>
			<!-----Video and comments about course----->
			<div class="sm-col-span-8 lg-col-span-4 content-left">
				<div class="course-name">
					<h1>English</h1>
					Giáo viên: <a href="#">Nguyễn Văn A</a>
				</div>
				<div class="video-content">
					<video controls>
						<source src="" type="video/mp4">
						<source src="" type="video/ogg">
					</video>
				</div>
				<!---------Course document------->
				<div class="document">
					<div class="document-links">Tài liệu: </div>
				</div>
				<!---------Answer and question-------------------------->
				<div class="comments">
					<div class="comments-title">Thảo luận với giáo viên</div>
					<div class="comments-b">
						<form method="POST" action="" id="form-c">
							<h3>Bình luận</h3>
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
			<div class="sm-col-span-4 lg-col-span-4">
				<div class="content-wr">
					<!---------links register courses - hiden will payment--------->
					<div class="sm-col-span-12 lg-col-span-4 course-register">
						<div class="course-t">
							<p class="course-hp"><span>600.000 </span>đồng</p>
							<div class="course-buy">
								<a href="#">Đăng ký ngay</a>
							</div>
						</div>
					</div>
					<div class="sm-col-span-12 lg-col-span-4 course-history">
						<div class="course-his-head">
							TIẾN ĐỘ KHÓA HỌC
						</div>
						<div class="course-his-b">
							<div class="his-b-total-c">
								Số bài đã học - Tổng số bài: <span>1</span> / <span>24</span>
							</div>
							<div class="his-b-total-t">
								Số bài đã kiểm tra - Tổng số bài: <span>1</span> / <span>10</span>
							</div>
							<div class="his-b-total-score">
								Điểm trung bình các bài kiểm tra:
							</div>
						</div>
					</div>
					
					<!------------Course lessons ---------------->
					<div class="sm-col-span-12 lg-col-span-4">
						<div class="course-struct">
							<div class="course-st-head">
								<div class="course-st-title">
									LESSONS
								</div>
							</div>
							<div class="course-st-b">
								<div class="course-st-row">
									<div class="st-less"><b>Bài 01 </b></div>
									<div class="st-name">Lorem Ipsum is simply dummy text of the printing and typesetting industry.</div>
									<div class="st-cr-study">
										<div class="watched">
											<a href="#">Đã học</a>
										</div>
									</div>
								</div>
								<div class="course-st-row">
									<div class="st-less"><b>Bài 02 </b></div>
									<div class="st-name">Lorem Ipsum is simply dummy text of the.</div>
									<div class="st-cr-study">
										<div class="watch">
											<a href="#">Xem</a>
										</div>
									</div>
								</div>
								<div class="course-st-row">
									<div class="st-less"><b>Bài 03 </b></div>
									<div class="st-name">Lorem Ipsum is simply dummy text of the printing and typesetting.</div>
									<div class="st-cr-study">
										<div class="watch">
											<a href="#">Xem</a>
										</div>
									</div>
								</div>
								<div class="course-st-row">
									<div class="st-less"><b>Bài 04 </b></div>
									<div class="st-name">Lorem Ipsum is simply dummy text of the printing and typesetting.</div>
									<div class="st-cr-study">
										<div class="watched">
											<a href="#">Đã học</a>
										</div>
									</div>
								</div>
							</div>
						</div>
						<!--- Course test--->
						<div class="course-struct">
							<div class="course-st-head">
								<div class="course-st-title">
									TEST
								</div>
							</div>
							<div class="course-st-b">
								<div class="course-st-row">
									<div class="st-less"><b>Bài 01 </b></div>
									<div class="st-name">Lorem Ipsum is simply dummy text of the printing and typesetting industry.</div>
									<div class="st-cr-study">
										<div class="watched">
											<a href="#">10/10</a>
										</div>
									</div>
								</div>
								<div class="course-st-row">
									<div class="st-less"><b>Bài 02 </b></div>
									<div class="st-name">Lorem Ipsum is simply dummy text of the printing and typesetting industry.</div>
									<div class="st-cr-study">
										<div class="watched">
											<a href="#">10/10</a>
										</div>
									</div>
								</div>
							</div>
						</div>
						<!----------links fanpage-------------->
						<div class="course-struct fanpage">
							<div class="course-st-head fanpage-head">
								<div class="course-st-title fanpage-title">
									FANPAGE
								</div>
							</div>
							<div class="fanpage-body">
								Theo dõi để cập nhật tin tức về khóa học sắp diễn ra
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