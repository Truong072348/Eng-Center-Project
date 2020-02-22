@extends('pages.index')
@section('style')
<link rel="stylesheet" type="text/css" href="{{ secure_asset('css/page-account.css') }}">
@endsection
@section('content')
<div class="wrapper">
	@include('layout.banner')
	<div class="row">
		<div class="sm-col-span-12 lg-col-span-4">
			<div class="acc-func-wr">
				<div class="acc-func-left">
					<nav>
						<ul class="ac-func-menu-l">
							<li class="active" id="page1"><a class="page">Số dư tài khoản</a></li>
							<li id="page2"><a class="page">Lịch sử đăng ký khóa học</a></li>
							<li><a>Trợ giúp</a></li>
						</ul>
					</nav>
				</div>
				@if($page == 1)
				<div class="acc-info-right">
					<div class="accout-surplus">
						@php($price = number_format(Auth::user()->account_balance, 0, '', '.'))
						Số dư trong tài khoản <span>{{$price}}</span> VND
					</div>
					<form action="" method="post">
					<div class="accout-recharge">

						<button>Nạp tiền vào tài khoản</button>
					</div>
					</form>
				</div>
				@elseif($page == 2)
				<div class="acc-info-right">
					<h3>Thông tin đăng ký khóa học</h3>
					@if(isset($register))
					@foreach($register as $re)
					<div class="course-register">
						<div class="cr-rg-head">
								@foreach($courseTotal as $course)
								@if($course->id == $re->id_course)
								<a href="course/{{$course->id}}">
								
								{{$course->name}}
								@endif
								@endforeach
								</a> <i class="far fa-calendar-alt"></i> Ngày đăng ký: <span>{{$re->created_at}}</span>
								<div class="cr-rg-teacher">
									Giáo viên:
									@foreach($courseTotal as $course)
									@if($course->id == $re->id_course)
									@foreach($teacherList as $teacher)
									@if($teacher->id == $course->id_teacher)
									<a href="teacher/{{$teacher->id}}">
										
										{{$teacher->name}}
										
									</a>
									@endif
									@endforeach
									
								</div>
								@endif
								@endforeach
								<div class="cr-rg-price">
									@php($price = number_format($re->price, 0, '', '.'))
									Học phí: <span>{{$price}}</span><sup> đồng</sup>
								</div>
							</div>
							<div class="cr-rg-body">
								@foreach($courseTotal as $course)
								@if($course->id == $re->id_course)
								<p>{{$course->short_description}}</p>
								@endif
								@endforeach
								
							</div>
						</div>
						@endforeach
						@endif
					</div>
					@else
					Không tìm thấy dữ liệu
					@endif
					<input type="hidden" name="id" value="{{Auth::user()->id}}">
				</div>
				
			</div>
		</div>
	</div>
	@endsection
	@section('script')
	<script type="text/javascript">
		$(document).ready(function(){
			$(document).on('click', '.page', function(){
				$('.page').parent().removeClass('active');
				$(this).parent().addClass('active');
				var $type = $(this).parent().attr('id');
				if($type == 'page1'){
					var $page = 1;
				} else {
					var $page = 2;
				}

				var $id = $('input[name=id]').val();
				$.ajax({
				url: 'account/' + $id,
				type: 'get',
				data: {
					_type: $page,
				},
				
				success: function(data){
					var $content = $(data).find('.acc-info-right').html();
					$('.acc-info-right').empty().html($content);
				},
				error: function(e){
					$('.acc-info-right').html('<p>Load Error!!!<p>');
											console.log(e.message);
										}
								});
							});
						});
		</script>
		<script src="{{ secure_asset('js/page-index.js') }}"></script>
		@endsection