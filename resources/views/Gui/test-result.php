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
					<div class="content-wr-qs">
						<div class="test-content">
							<div class="test-title">
								<h3><span>English For All</span> - <span>Test 01</span> - <span>Noun</span></h3>
							</div>
							<form method="POST" action="" id="form-test">
								<div class="test-content-question">
									<div class="c-question-number">
										Question<span>1</span>
									</div>
									<div class="c-question-content">
										<div class="question">
											Lorem Ipsum __________ simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s
										</div>
										<div class="answer">

											<ul>
												<li class="correctAs"><input type="radio" name="answer">a. <span>is</span></li>
												<li><input type="radio" name="answer">b. <span>are</span></li>
												<li class="failAs"><input type="radio" name="answer" checked>c. <span>has</span></li>
												<li><input type="radio" name="answer">d. <span>have</span></li>
											</ul>
											<div class="correctAnswer">Correct Answer: is</div>
										</div>
									</div>
								</div>
								<div class="test-content-question">
									<div class="c-question-number">
										Question<span>1</span>
									</div>
									<div class="c-question-content">
										<div class="question">
											Lorem Ipsum __________ simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s
										</div>
										<div class="answer">
											<ul>
												<li class="correctAs"><input type="radio" name="answer">a. <span>is</span></li>
												<li><input type="radio" name="answer">b. <span>are</span></li>
												<li><input type="radio" name="answer">c. <span>has</span></li>
												<li><input type="radio" name="answer">d. <span>have</span></li>
											</ul>
											<div class="correctAnswer">Correct Answer: is</div>
										</div>
									</div>
								</div>
								<div class="test-content-question">
									<div class="c-question-number">
										Question<span>1</span>
									</div>
									<div class="c-question-content">
										<div class="question">
											Lorem Ipsum __________ simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s
										</div>
										<div class="answer">
											<ul>
												<li class="correctAs"><input type="radio" name="answer">a. <span>is</span></li>
												<li><input type="radio" name="answer">b. <span>are</span></li>
												<li><input type="radio" name="answer">c. <span>has</span></li>
												<li><input type="radio" name="answer">d. <span>have</span></li>
											</ul>
											<div class="correctAnswer">Correct Answer: is</div>
										</div>
									</div>
								</div>
								<div class="test-content-question">
									<div class="c-question-number">
										Question<span>1</span>
									</div>
									<div class="c-question-content">
										<div class="question">
											Lorem Ipsum __________ simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s
										</div>
										<div class="answer">
											<ul>
												<li class="correctAs"><input type="radio" name="answer">a. <span>is</span></li>
												<li><input type="radio" name="answer">b. <span>are</span></li>
												<li><input type="radio" name="answer">c. <span>has</span></li>
												<li><input type="radio" name="answer">d. <span>have</span></li>
											</ul>
											<div class="correctAnswer">Correct Answer: is</div>
										</div>
									</div>
								</div>
								<div class="btn-group">
									<a href="#">Tiếp theo</a>
								</div>
							</form>
						</div>
						<div class="total-question">
							<div class="time-test-finish">Time <span>29:00</span></div>
							<div class="list-q">
								<ul class="clear-fix">
								</ul>
							</div>
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