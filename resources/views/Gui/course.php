<!DOCTYPE html>
<html>
	<head>
		<?php include("head.php"); ?>
		<link rel="stylesheet" type="text/css" href="css/index.css">
		<link rel="stylesheet" type="text/css" href="css/course.css">
	</head>
	<body>
	<header> <?php include("header.php"); ?></header>
	<div class="wrapper">
		<div class="row">
			<div class="breadcrumb-wr">
				<nav>
					<ul class="breadcrumb clear-fix">
						<li><a href="#"><i class="fas fa-home"></i> Trang chủ</a></li>
						<li>Khóa học</li>
					</ul>
				</nav>
			</div>
		</div>
		<div class="row">
			<div class="sm-col-span-3 menu-left">
				<nav class="nav-menu-left">
					<ul class="sidebar clear-fix">
						<li>
							<div class="side-title">
								DOCUMENT
							</div>
							<ul class="side clear-fix">
								<li><a href="#">Toeic</a></li>
								<li><a href="#">Ielts</a></li>
								<li><a href="#">Listening</a></li>
							</ul>
						</li>
						<li>
							<div class="side-title">
								TEST
							</div>
							<ul class="side clear-fix">
								<li><a href="#">English</a></li>
								<li><a href="#">English</a></li>
								<li><a href="#">English</a></li>
							</ul>
						</li>
						<li>
							<div class="side-title dropdown-menu">
								TOEIC <i class="fas fa-chevron-right"></i>
							</div>
							<ul class="side clear-fix">
								<li><a href="#">English</a></li>
								<li><a href="#">English</a></li>
								<li><a href="#">English</a></li>
							</ul>
						</li>
						<li>
							<div class="side-title dropdown-menu">
								IELTS <i class="fas fa-chevron-right"></i></h3>
							</div>
							<ul class="side clear-fix">
								<li><a href="#">English</a></li>
								<li><a href="#">English</a></li>
								<li><a href="#">English</a></li>
							</ul>
						</li>
					</ul>
				</nav>
			</div>
			<div class="sm-col-span-8 md-col-span-8 lg-col-span-4 content">
				<div class="container-course-wr">
					<div class="course-wr">
						<div class="course">
							<div class="course-img">
								<a href="#"></a>
								<span class="price">2.000.000</span>
							</div>
							<div class="course-c">
								<p class="course-title"><span>Toeic Special 400</span></p>
								
								<p class="course-desc">Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p>
								<a href="course-detail.php">Learn more</a>
							</div>
						</div>
						<div class="course">
							<div class="course-img">
								<a href="#"></a>
								<span class="price">2.000.000</span>
							</div>
							<div class="course-c">
								<p class="course-title"><span>Toeic Special 400</span></p>
								
								<p class="course-desc">Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p>
								<a href="#">Learn more</a>
							</div>
							
						</div>
						<div class="course">
							<div class="course-img">
								<a href="#"></a>
								<span class="price">2.000.000</span>
							</div>
							<div class="course-c">
								<p class="course-title"><span>Toeic Special 400</span></p>
								<p class="course-desc">Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p>
								<a href="#">Learn more</a>
							</div>
							
						</div>
						<div class="course">
							<div class="course-img">
								<a href="#"></a>
								<span class="price">2.000.000</span>
							</div>
							<div class="course-c">
								<p class="course-title"><span>Toeic Special 400</span></p>
								<p class="course-desc">Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p>
								<a href="#">Learn more</a>
							</div>
							
						</div>
						<div class="course">
							<div class="course-img">
								<a href="#"></a>
								<span class="price">2.000.000</span>
							</div>
							<div class="course-c">
								<p class="course-title"><span>Toeic Special 400</span></p>
								<p class="course-desc">Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p>
								<a href="#">Learn more</a>
							</div>
							
						</div>
						<div class="course">
							<div class="course-img">
								<a href="#"></a>
								<span class="price">2.000.000</span>
							</div>
							<div class="course-c">
								<p class="course-title"><span>Toeic Special 400</span></p>
								<p class="course-desc">Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p>
								<a href="#">Learn more</a>
							</div>
							
						</div>
					</div>
				</div>
				<div class="sm-col-span-12 lg-col-span-4">
					<div class="pagination">
						<ul class="clear-fix">
							<li><a class="active" href="#">1</a></li>
							<li><a href="#">2</a></li>
							<li><a href="#">3</a></li>
							<li><a href="#">4</a></li>
						</ul>
					</div>
				</div>
			</div>
		</div>
	</div>
	<?php include("footer.php"); ?>
	<script type="text/javascript">
		$('.dropdown-menu').on("click", function(){
			$(this).next(".side").slideToggle("slow");
		});
	</script>
</body>
</html>