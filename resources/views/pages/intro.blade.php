@extends('pages.index')
@section('style')
<link rel="stylesheet" type="text/css" href="{{ secure_asset('css/page-intro.css') }}">
<link rel="stylesheet" type="text/css" href="css/page-intro.css">
@endsection
@section('content')
@if(isset($intro))
<div class="wrapper">
	<div class="row">
		<nav>
			<ul class="breadcrumb clear-fix">
				<li><a href="index"><i class="fas fa-home"></i> Trang chủ</a></li>
				<li><a href="#">Khóa học</a></li>
				<li>{{$intro->name}}</li>
			</ul>
		</nav>
		
		<div class="sm-col-span-8 lg-col-span-4 content">
			<div class="course-content-wr">
				@if(session('success'))
				<div class="alert alert-success">
					{{session('success')}}
				</div>
				@endif
				<h1 class="course-title-wr">{{$intro->name}}</h1>
				<div class="course-category">
					@foreach($typeCList as $type)
					@if($type->id == $intro->id_ctype)
					@foreach($categoryList as $cate)
					@if($cate->id == $type->id_category)
					<span>{{$cate->name}}</span> ||
					@endif
					@endforeach
					<span>{{$type->level}}</span>
					@endif
					@endforeach
				</div>
				<p class="course-intro">{{$intro->description}}</p>
				<div class="course-teacher">
					Giáo viên: <a href="#">{{$teacher->name}}</a>
				</div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="sm-col-span-12 lg-col-span-4 content">
			<div class="video-content">
				<video controls>
					<source src="upload/video/jYJnR_video_01.mp4" type="video/mp4">
				</video>
				<div class="menu-uner-v">
					<nav>
						<ul class="clear-fix">
							<li class="bookmark"><a>Mô tả khóa học</a></li>
							<li class="bookmark"><a>Bài giảng miễn phí</a></li>
							<li class="bookmark"><a>Giáo viên giảng dạy</a></li>
							<li class="bookmark"><a><img src="Images/star.png">Đánh giá</a></li>
						</ul>
					</nav>
				</div>
			</div>
			<div class="course-detail">
				@if(isset($registered))
				<div class="course-t">
					@if($registered == false)
					@php($price = number_format($intro->price, 0, '', '.'))
					<p class="course-hp"><img src="Images/price-tag.png"><span>Học phí: </span><span id="price">{{$price}}</span>đồng</p>
					
					@if(Auth::check())
					<div class="course-buy">
						<a href="payment/{{$intro->id}}">Đăng ký ngay</a>
					</div>
					@else
					<div class="modal" id="ex3" >
						<p>Bạn chưa đăng nhập.</p>
						<a class="out-submit" id="inLogin">Đăng nhập ngay</a>
					</div> 
					<div class="course-buy">
						<a href="#ex3" rel="modal:open">Đăng ký ngay</a>
					</div>
					@endif
					<div class="course-free">
						<a href="#lessons">Học thử miễn phí</a>
					</div>
					@else
					<div class="registered">
						<img src="Images/checked.png">
						Đã đăng ký
					</div>
					@endif
				</div>
				@endif
				<div class="course-m">
					<nav>
						<ul class="clear-fix">
							<li class="course-m-sec">
								<h3><img src="Images/star.png">Mục tiêu khóa học</h3>
								<ul>
									<li>{{$intro->short_description}} </li>
								</ul>
							</li>
							<li class="course-m-sec">
								<h3><img src="Images/book.png">Cấu trúc khóa học</h3>
								<ul class="child clear-fix">
									<li>{{$lessons->count()}} Bài học</li>
									<li>{{$tests->count()}} Bài kiểm tra</li>
									<li>Thời hạn : </br>
										Ngày bắt đầu: {{$intro->date_finish}} </br>
										Ngày kết thúc: Đang cập nhật
									</li>
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
						<div id="teacher-c">
							<h3>Giáo viên</h3>
							<cite>"{{$teacher->slogan}}"</cite>
							</br>
							{{$teacher->introduction}}
						</div>
						<a id="watch">Xem thêm</a>
					</div>
					<div class="des-re">
						<h3>Nội dung</h3>
						{{$intro->description}}
						
					</div>
					<div class="des-per">
						<h3>Đối tượng</h3>
						Đang cập nhật	
					</div>
				</div>
				<div class="course-struct">
					<div class="course-st-head">
						<div class="course-st-title" id="lessons">
							LESSONS
						</div>
					</div>
					<div class="course-st-b">
						@if(isset($lessons))
						@foreach($lessons as $t=>$l)
						<div class="course-st-row">
							<div class="st-less"><b>Bài {{$t + 1}} </b></div>
							<div class="st-name">{{$l->lesson}}</div>
							<div class="st-cr-test">
								@if($registered == true)
								<div class="link-test">
									<a href="lesson/{{$l->id}}">Watch</a>
								</div>
								@else
								@if($t < 2)
								@if(Auth::check())
								<div class="link-test">
									<a href="lesson/{{$l->id}}">Free</a>
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
						@endif
					</div>
				</div>
				<div class="course-struct">
					<div class="course-st-head">
						<div class="course-st-title" id="lessons">
							TEST
						</div>
					</div>
					<div class="course-st-b">
						@if(isset($tests))
						@foreach($tests as $t=>$test)
						<div class="course-st-row">
							<div class="st-less"><b>Test {{$t + 1}}</b></div>
							<div class="st-name">{{$test->name}}</div>
							<div class="st-cr-test">
								@if($registered == true)
								<div class="link-test">
									<a href="lesson/{{$l->id}}">Work</a>
								</div>
								@endif
							</div>
						</div>
						@endforeach
						@endif
					</div>
				</div>
				<div class="comment">
					@if(Auth::check())
					<form method="POST" action="comment" id="form-c">
						<h3 id="comment">Đánh giá khóa học</h3>
						<a name="comment"></a>
						<input type="hidden" name="_token" value="{{csrf_token()}}">
						<input type="hidden" name="idcourse" value="{{$intro->id}}">
						<input type="hidden" name="local" value="0">
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
					<div class="total-comment" id="btn-add">
						<div class="btn-add">
							Viết bình luận
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
											<span class="name">{{$student->name}}</span>
											<span class="time">
												@endif
												@endforeach
												@foreach($teacherList as $teacher)
												@if($teacher->id == $comment->id_user)
											</span>
											<span class="name">{{$teacher->name}}</span>
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
													<span class="name">{{$student->name}}</span>
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
					<div class="sm-col-span-12 lg-col-span-4">
							<div class="pagination-wr">
								{{$comments->links()}}
							</div>
						</div>
					@endif
				</div>
			</div>
		</div>
		<div class="sm-col-span-4 md-col-span-3 lg-col-span-4">
			<div class="course-ref">
				<h3>Khóa học liên quan</h3>
				@if(isset($refs[0]))
				@foreach($refs as $r=>$ref)
				
				<div class="course-ref-content">
					<div class="course-img">
						<a href="course/{{$ref->id}}"><img src="Images/{{$ref->image}}"></a>
					</div>
					<div class="course-c">
						@if($r < 3)
						<p class="triangle top-{{$r + 1}}"></p>
						<span class="top">{{$r + 1}}</span>
						@endif
						<p class="course-title">{{$ref->name}} -
							@foreach($teacherList as $teacher)
							@if($teacher->id == $ref->id_teacher)
							<span>{{$teacher->name}}</span>
							@endif
							@endforeach
						</p>
						@php($price = number_format($ref->price, 0, '', '.'))
						<p class="course-price"><span>{{$price}}</span></p>
						<a href="course/{{$ref->id}}" class="learn">learn more</a>
					</div>
				</div>
				@endforeach
				@endif
			</div>
		</div>
	</div>
</div>
@endif
@endsection
@section('script')
<script type="text/javascript">
	$('#teacher-c').addClass('teacher-intro-close');
	$(document).on('click', '#watch', function(){
		$('#teacher-c').toggleClass('teacher-intro');
		var clicks = $(this).data('clicks');
		if (clicks) {
		$(this).html('Xem thêm');
		} else {
		$(this).html('Ẩn');
		}
		$(this).data("clicks", !clicks);
	});
	$(document).on('click', '#btn-add', function(){
		$('#ex1').modal('open');
		});
	$(document).on('click', '.link-free', function(){
		$('#ex1').modal('open');
		});
	$(document).on('click', '.replay', function(){
		var $idcomment = $(this).closest('.comment-info').find('.idcomment').val();
		var $form = '<form method="POST" action="replay/'+$idcomment+'" id="form-replay">'+
					'<input type="hidden" name="_token" value="{{csrf_token()}}">'+
					'<textarea name="replay"></textarea>'+
					'<div class="btn-group">'+
					'<button type="submit" class="btn-comment">Bình luận</button>'+
					'</div></form>';
			$(this).closest('.comments-history-qa li').append($form);
		});

	//open modal login
	$(document).on('click', '#inLogin', function(){
		$('#ex1').modal('open');
	});
</script>
<script src="{{ secure_asset('js/page-index.js') }}"></script>
<script src="js/page-index.js"></script>
@endsection