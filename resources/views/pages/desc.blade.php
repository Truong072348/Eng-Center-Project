@extends('pages.index')
@section('style')
<link rel="stylesheet" type="text/css" href="{{ secure_asset('css/page-intro.css') }}">
<link rel="stylesheet" type="text/css" href="css/page-intro.css">
<link rel="stylesheet" type="text/css" href="{{ secure_asset('css/page-desc.css') }}">
<link rel="stylesheet" type="text/css" href="css/page-desc.css">
@endsection
@section('content')
<div class="wrapper">
	<div class="row">
		<div class="sm-col-span-12 lg-col-span-4">
			<nav>
				<ul class="breadcrumb clear-fix">
					<li><a href="index"><i class="fas fa-home"></i> Trang chủ</a></li>
					<li><a href="course">Khóa học</a></li>
					<li><a href="course/{{$course->id}}">{{$course->name}}</a></li>
					<li>{{$lesson->lesson}}</li>
				</ul>
			</nav>
		</div>
	</div>
</div>
<div class="wr">
	<!-----Video and comments about course----->
	<div class="content-left">
		<div class="course-name">
			<h1>{{$lesson->lesson}}</h1>
			<input type="hidden" name="id" value="{{$lesson->id}}">
			<h3>{{$course->name}} / <a href="teacher/{{$teacher->id}}">{{$teacher->name}}</a></h3>
		</div>
		<div class="video-content">
			<video controls>
				<source src="upload/video/{{$lesson->links_video}}" type="video/mp4">
			</video>
		</div>
		<!---------Course document------->
		<div class="document">
			<div class="document-links">Tài liệu: <a href="download/{{$lesson->links_document}}">Download document</a></div>
		</div>
		<!---------Answer and question-------------------------->
		<div class="comments">
			@if(Auth::check())
			@if($registered == true)
			<form method="POST" action="comment" id="form-c">
				<h3 id="comment">Đánh giá khóa học</h3>
				<a name="comment"></a>
				<input type="hidden" name="_token" value="{{csrf_token()}}">
				<input type="hidden" name="idcourse" value="{{$course->id}}">
				<input type="hidden" name="local" value="1">
				<textarea name="comment" id="editor1" placeholder=""></textarea>
				@if($errors->has('comment'))
				<div class="notify-error">
					{{$errors->first('comment')}}
				</div>
				@endif
				<div class="btn-group">
					<button type="submit" class="btn-comment">Bình luận</button>
				</div>
			</form>
			@else 
			<div class="register">
				Bạn chưa đăng ký khóa học
			</div>
			@endif
			@else
			<div class="total-comment" id="btn-add">
				<div class="btn-add">
					Thảo luận với giáo viên
				</div>
			</div>
			@endif
			<!-----------------comment of student--------------------------->
			@if(count($comments) > 0)
			<div class="comments-history">
				<ul class="comments-history-qa clear-fix">
					@foreach($comments as $comment)
					<li>
						<div class="comment-his-ac">
							<div class="comment-acc">
								@foreach($studentList as $student)
								@if($student->id == $comment->id_user)
								<img src="Images/{{$student->avatar}}">
								@endif
								@endforeach
								@foreach($teacherList as $teacher)
								@if($teacher->id == $comment->id_user)
								<img src="Images/{{$teacher->avatar}}">
								@endif
								@endforeach
							</div>
							
							<div class="comment-info">
								<input type="hidden" class="idcomment" value="{{$comment->id}}">
								<div class="comment-time">
									@foreach($studentList as $student)
									@if($student->id == $comment->id_user)
									<span class="name">{{$student->name}}
									</span>
									<span class="time">
										@endif
										@endforeach
										@foreach($teacherList as $teacher)
										@if($teacher->id == $comment->id_user)
									</span>
									<span class="name">{{$teacher->name}}
									</span>
									<span class="time">
										@endif
										@endforeach
										{{$comment->created_at}}
									</span>
								</div>
								<div class="comment-ques">
									{{$comment->content}}
								</div>
								<div class="comment-rep-links">
									@if(Auth::check())
									<a class="replay">Trả lời</a>
									<!-- <a href="#">Xóa bình luận</a> -->
									@endif
								</div>
							</div>
						</div>
						@if(isset($feedback))
						<ul class="comments-history-answer clear-fix">
							
							@foreach($feedback as $feed)
							@if($feed->id_comment == $comment->id)
							<li>
								<div class="comment-his-ac">
									<div class="comment-acc">
										@foreach($studentList as $student)
										@if($student->id == $feed->id_users)
										<img src="Images/{{$student->avatar}}">
										@endif
										@endforeach
										@foreach($teacherList as $teacher)
										@if($teacher->id == $feed->id_users)
										<img src="Images/{{$teacher->avatar}}">
										@endif
										@endforeach
									</div>
									<div class="comment-info">
										<div class="comment-time">
											@foreach($studentList as $student)
											@if($student->id == $feed->id_users)
											<span class="name">{{$student->name}}
											</span>
											<span class="power student">
												Học viên
											</span>
											<span class="time">
												@endif
												@endforeach
												@foreach($teacherList as $teacher)
												@if($teacher->id == $feed->id_users)
											</span>
											<span class="name">{{$teacher->name}}</span>
											<span class="power teacher">
												Giáo viên
											</span>
											
											@endif
											@endforeach
											<span class="time"> {{$feed->created_at}}</span>
										</div>
										<div class="comment-ques">
											{{$feed->answer}}
										</div>
									</div>
								</div>
							</li>
							@endif
							@endforeach
							
						</ul>
						@endif
					</li>
					@endforeach
				</ul>
			</div>
			@endif
		</div>
	</div>
	<div class="content-wr">
		<!---------links register courses - hiden will payment--------->
		@if(isset($registered))
		@if($registered == false)
		<div class="course-register">
			<div class="course-t">
				<p class="course-hp">
					<img src="Images/price-tag.png">
					@php($price = number_format($course->price, 0, '', '.'))
					<span>{{$price}}</span>đồng
				</p>
				<div class="course-buy">
					<a href="payment/{{$course->id}}">Đăng ký ngay</a>
				</div>
			</div>
		</div>
		@endif
		@endif
		<div class="course-history">
			<div class="course-his-head">
				<img src="Images/progress-report.png"> TIẾN ĐỘ KHÓA HỌC
			</div>
			<div class="course-his-b">
				<div class="his-b-total his-b-total-c">
					Số bài đã học <span id="c">0</span> / <span id="c-t">{{count($lessonList)}}</span>
					<div class="progressbar">
						<div id="lessonbar"></div>
					</div>
				</div>
				<div class="his-b-total his-b-total-t">
					Số bài đã kiểm tra 
					<span id="t">
					@if($registered == true)
						{{count($studyTest)}}
					@endif
					</span> / <span id="t-t">{{count($test)}}</span>
					<div class="progressbar">
						<div id="testbar"></div>
					</div>
				</div>
				<div class="his-b-total his-b-total-score">
					<!-- Điểm trung bình các bài kiểm tra:
					@php($score = 0)
					@if($registered == true)
						@if(count($studyTest) > 0)
						@foreach($studyTest as $mark)
						@php($score = $score + $mark->score)
						@endforeach
						@php($total = $score / count($studyTest))
						@endif
					@endif
					{{$score}} -->
				</div>
			</div>
		</div>
		
		<!------------Course lessons ---------------->
		
		@if(isset($lessonList))
		<div class="course-struct">
			<div class="course-st-head">
				<div class="course-st-title">
					LESSONS
				</div>
			</div>
			<div class="course-st-b">
				@foreach($lessonList as $l=>$lesson)
				<div class="course-st-row">
					<div class="st-less"><b>Bài <span>{{$l + 1}}</span></b></div>
					<div class="st-name">{{$lesson->lesson}}</div>
					<div class="st-cr-study">
					@if($registered == true)
					
					@php($check = 0)
					@foreach($watched as $w)
					@if($w->id_lesson == $lesson->id)
					<div class="watched">
						<a href="lesson/{{$lesson->id}}">Again</a>
					</div>
					@php($check = 1)
					@endif
					@endforeach

					@if($check == 0)
					<div class="watch">
						<a href="lesson/{{$lesson->id}}">Watch</a>
					</div>
					@endif

					@else
					@if($l < 2)
					@if(Auth::check())
					<div class="link-test">
						<a href="lesson/{{$lesson->id}}">Free</a>
					</div>
					@else
					<div class="link-test">
						<a class="link-free">Free</a>
					</div>
					@endif
					@endif
					@endif
					</div>
				</div>
				@endforeach
			</div>
		</div>
		@endif
		<!--- Course test--->
		@if(isset($test))
		<div class="course-struct">
			<div class="course-st-head">
				<div class="course-st-title">
					TEST
				</div>
			</div>
			<div class="course-st-b">
				@foreach($test as $key=>$t)
				<div class="course-st-row">
					<div class="st-less"><b>Bài {{$key + 1}} </b></div>
					<div class="st-name">{{$t->name}}</div>
					<div class="st-cr-test">
						@if($registered == true)
						@php($testCheck = 0)
						@if(count($studyTest) > 0)
						@foreach($studyTest as $study)
						@if($study->id_test == $t->id)
						<div class="tested">
							<a href="overview/{{$t->id}}">Review</a>
						</div>
						@php($testCheck = 1)
						@endif
						@endforeach
						@endif

						@if($testCheck == 0)
						<div class="test">
							<a href="overview/{{$t->id}}">Test</a>
						</div>
						@endif

						@endif
					</div>
				</div>
				@endforeach
			</div>
		</div>
		@endif
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
@endsection
@section('script')
<script type="text/javascript">
	$(document).ready(function(){
		$('#c').text($('.st-cr-study .watched').length);
		var $watched = $('#c').text();
		var $totalCourse = $('#c-t').text();
		var $widthLess = $watched / $totalCourse * 100 + '%';
		
		$('#lessonbar').css('width', $widthLess);
		var $worked = $('#t').text();
		var $totalTest = $('#t-t').text();
		var $widthTest = $worked / $totalTest * 100 + '%';
		$('#testbar').css('width', $widthTest);


		$('video').on('ended', function(){
			$id = $('input[name=id]').val();
			$.ajax({
					url: 'studylesson',
					type: 'POST',
					data: {
					"_token": "{{ csrf_token() }}",	
					_id: $id
				}, 
				success: function(data) {
					console.log(data);
				}
			});
		});

		$(document).on('click', '#btn-add', function(){
			$('.modal').modal('open');
		});

		$(document).on('click', '.replay', function(){
		var $idcomment = $(this).closest('.comment-info').find('.idcomment').val();
		var $form = '<form method="POST" action="replayCourse/'+$idcomment+'" id="form-replay">'+
					'<input type="hidden" name="_token" value="{{csrf_token()}}">'+
					'<textarea name="replay"></textarea>'+
					'<div class="btn-group">'+
					'<button type="submit" class="btn-comment">Bình luận</button>'+
					'</div></form>';
			$(this).closest('.comments-history-qa li').append($form);
		});
		
	});
</script>
@if($registered == true)
@endif

<script src="{{ secure_asset('js/page-index.js') }}"></script>
<script src="js/page-index.js"></script>
@endsection