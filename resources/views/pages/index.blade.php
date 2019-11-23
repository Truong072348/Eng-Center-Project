@extends('layout.index')
@section('style')
<link rel="stylesheet" type="text/css" href="css/index.css">
@endsection
@section('content')
<div class="wrapper">
	<div class="row">
		<div class="slider" id="slider">
			<div class="slide one">
				<img src="./Images/banner-1.png">
				<div class="slidecontent active">
					<h1>Học tiếng anh online hiệu quả!</h1>
					<p><a href="register">Register Now</a></p>
				</div>
			</div>
			<div class="slide two">
				<img src="./Images/banner-2.png">
				<div class="slidecontent">
					<h1>
						Website Học Tiếng Anh online số 1 tại Việt Nam
					</h1>
					<p><a href="register">Register Now</a></p>
				</div>
			</div>
			<div class="slide three">
				<img src="./Images/banner-3.png">
				<div class="slidecontent">
					<h1>Gần 5.000 từ vựng, 50.000 cặp câu luyện nói tiếng anh</h1>
					<p><a href="register">Register Now</a></p>
				</div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="container clear-fix">
			<div class="sm-col-span-4 md-col-span-8 lg-col-span-4">
				<div class="intro-wr">
					<div class="intro">
						<div class="box-intro">
							<span class="icon">
								<img src="./Images/icon-book.png">
							</span>
							<div class="intro">
								<h3>Khóa học Toeic</h3>
								<p><a href="list/Toeic">Xem thêm</a></p>
							</div>
						</div>
						<div class="box-intro">
							<span class="icon">
								<img src="./Images/icon-book.png">
							</span>
							<div class="intro">
								<h3>Khóa học Ielts</h3>
								<p><a href="list/Ielts">Xem thêm</a></p>
							</div>
						</div>
						<div class="box-intro box-third">
							<div class="intro">
								<h3>Khóa học online sale 50%</h3><span>You will improve your knowledge of the English test.</span></br>
								<p><a href="#">Xem thêm</a></p>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="sm-col-span-8 md-col-span-8 lg-col-span-4">
				<div class="about-wr-right">
					<h2>Welcom to DLD</h2>
					<p>Tổng hợp các khóa học tiếng anh từ cơ bản đến nâng cao. Bài học bao gồm từ vựng, cặp câu cách sử dụng các câu nói tiếng anh thông dụng.Trong các khóa học tiếng Anh trực tuyến miễn phí này từ DLD, sinh viên sẽ học tiếng Anh trực tuyến thoải mái như ở nhà trong một môi trường trực tuyến.

Từ tiếng Anh đàm thoại đến từ vựng và phát âm, các khóa học tiếng Anh này hoàn toàn phù hợp cho những người muốn mài giũa kỹ năng tiếng Anh.

Văn bằng ngữ pháp tiếng Anh cơ bản đưa sinh viên đi sâu hơn vào hoạt động của ngôn ngữ tiếng Anh.</p>
					<div class="panel-group">
						<div class="panel">
							<div class="panel-heading">
								<h4><a  class="btn btn-panel">Why choose us</a></h4>
							</div>
							<div class="panel-content">
								<p>Tiếng Anh là ngôn ngữ được sử dụng rộng rãi nhất trên thế giới. Truyền thông là điều tối quan trọng đối với bất kỳ doanh nghiệp nào, hơn nữa trong thế giới đa dạng văn hóa ngày nay đan xen trong các công ty nhiều tỷ đồng.

Đừng bỏ lỡ cơ hội để bắt đầu thành thạo các kỹ năng tiếng Anh của bạn.</p>
							</div>
						</div>
						<div class="panel">
							<div class="panel-heading">
								<h4><a  class="btn btn-panel">Why choose us</a></h4>
							</div>
							<div class="panel-content">
								<p>Gần 5.000 từ vựng, 50.000 cặp câu luyện nói tiếng anh
Truy cập ngay với 99.000 VNĐ / 1 năm, học Tiếng Anh online thoải mái không giới hạn tài liệu</p>
							</div>
						</div>
						<div class="panel">
							<div class="panel-heading">
								<h4><a class="btn btn-panel">Why choose us</a></h4>
							</div>
							<div class="panel-content">
								<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.</p>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="container-service clear-fix">
			<div class="sm-col-span-12 lg-col-span-4">
				<div class="container">
					<div class="service-wr">
						<div class="service">
							<span class="icon">
								<img src="./Images/toeic.png">
							</span>
							<div class="desc">
								<h3><a href="list/Toeic">Toeic</a></h3>
								<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p>
							</div>
						</div>
						<div class="service">
							<span class="icon">
								<img src="./Images/ielts.png">
							</span>
							<div class="desc">
								<h3><a href="list/Ielts">Ielts</a></h3>
								<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. </p>
							</div>
						</div>
						<div class="service">
							<span class="icon">
								<img src="./Images/basic.png">
							</span>
							<div class="desc">
								<h3><a href="list/Basic">Basic English</a></h3>
								<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p>
							</div>
						</div>
						<div class="service">
							<span class="icon">
								<img src="./Images/document.png">
							</span>
							<div class="desc">
								<h3><a href="">Document</a></h3>
								<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry</p>
							</div>
						</div>
					</div>
				</div>
				
			</div>
		</div>
		<div class="container-counter">
			<div class="counter-img"></div>
			<div class="counter">
				<div class="counter-entry">
					<span class="icon">
						<img src="./Images/basic.png">
					</span>
					<div class="desc">
						<span class="count" data-from="0" data-to="1000" data-speed="500" data-refresh-distance="300">
							@if(isset($courseList))
								{{$courseList->count()}}
							@endif
						</span>
						<span class="name">Course</span>
					</div>
				</div>
				<div class="counter-entry">
					<span class="icon">
						<img src="./Images/teacher.png">
					</span>
					<div class="desc">
						<span class="count" data-from="0" data-to="1000" data-speed="500" data-refresh-distance="300">{{$teacherList->count()}}</span>
						<span class="name">Teacher</span>
					</div>
				</div>
				<div class="counter-entry">
					<span class="icon">
						<img src="./Images/student.png">
					</span>
					<div class="desc">
						<span class="count" data-from="0" data-to="1000" data-speed="500" data-refresh-distance="300">{{$studentList->count()}}</span>
						<span class="name">Student</span>
					</div>
				</div>
				<div class="counter-entry">
					<span class="icon">
						<img src="./Images/document.png">
					</span>
					<div class="desc">
						@php($document = $lessonList->count() + $testList->count())
						<span class="count" data-from="0" data-to="1000" data-speed="500" data-refresh-distance="300">{{$document}}</span>
						<span class="name">Document</span>
					</div>
				</div>
			</div>
		</div>
		<div class="container-course">
			<div class="course-title">
				<h2>Our Classes</h2>
				<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.</p>
			</div>
			<div class="course-wr">
				@if(isset($courseList))
				@foreach($courseList as $course)
				<div class="course">
					<div class="course-img">
						<a href="course/{{$course->id}}">
							<img src="Images/{{$course->image}}">
						</a>
						@php($price = number_format($course->price, 0, '', '.'))
						<span class="price">{{$price}}</span>
					</div>
					<div class="course-c">
						<p class="course-title"><span>{{$course->name}}</span></p>
						
						<p class="course-desc">{{$course->short_description}}</p>
						<a href="course/{{$course->id}}">Learn more</a>
					</div>
				</div>
				@endforeach
				@endif
			</div>
		</div>
	</div>
</div>
@endsection
@section('script')
<script src="js/jquery.simpleslider.js"></script>
<script src="js/page-index.js"></script>
@endsection