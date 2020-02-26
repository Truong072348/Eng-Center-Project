@extends('pages.index')
@section('style')
<link rel="stylesheet" type="text/css" href="{{ secure_asset('css/page-account.css') }}">
<!-- <link rel="stylesheet" type="text/css" href="css/page-account.css"> -->
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
							<li class="active" id="page1" ><a class="page">Cập nhật thông tin</a></li>
							<li id="page2"><a class="page">Thay đổi mật khẩu</a></li>
							<li><a>Trợ giúp</a></li>
						</ul>
					</nav>
				</div>
				@if(isset($student))
				<div class="acc-info-right">
					<input type="hidden" name="id" value="{{Auth::user()->id}}">
					@if(session('page'))
					<div class="change-pass">
						@if(session('notify'))
						<div class="alert alert-success">
							{{session('notify')}}
						</div>
						@endif
						@if(session('passerror'))
						<div class="alert alert-error">
							{{session('passerror')}}
						</div>
						@endif
						<form action="changepassword/{{Auth::user()->id}}" method="POST" class="form-register clear-fix">
							<h3>Cập nhật mật khẩu</h3>
							<input type="hidden" name="_token" value="{{csrf_token()}}">
							<div class="form-group sm-col-span-12 lg-col-span-4">
								<label>
									<p>Nhập mật khẩu hiên tại</p>
								</label>
								<input type="password" id="pass" name="pass">
								@if($errors->has('pass'))
								<div class="notify-error">
									{{$errors->first('pass')}}
								</div>
								@endif
							</div>
							<div class="form-group sm-col-span-12 lg-col-span-4">
								<label>
									<p>Mật khẩu mới</p>
								</label>
								<input type="password" id="newpass" name="newpass">
								@if($errors->has('newpass'))
								<div class="notify-error">
									{{$errors->first('newpass')}}
								</div>
								@endif
							</div>
							<div class="form-group sm-col-span-12 lg-col-span-4">
								<label>
									<p>Xác nhận lại mật khẩu</p>
								</label>
								<input type="password" id="rNewpass" name="cfpass">
								@if($errors->has('cfpass'))
								<div class="notify-error">
									{{$errors->first('cfpass')}}
								</div>
								@endif
							</div>
							<div class="btn-group sm-col-span-12 lg-col-span-4">
								<div class="btn-login">
									<button id="submit-pass">Xác nhận</button>
								</div>
							</div>
						</form>
					</div>
					@else
					@if($page == 1)
					<form action="profile/{{Auth::user()->id}}" method="POST" class="form-register clear-fix">
						<h3>Thông tin cá nhân</h3>
						<input type="hidden" name="_token" value="{{csrf_token()}}">
						<div class="form-group sm-col-span-12 lg-col-span-4">
							<label>
								<p>Họ tên</p>
							</label>
							<input type="text" name="name" value="{{$student->name}}">
							@if($errors->has('name'))
							<div class="notify-error">
								{{$errors->first('name')}}
							</div>
							@endif
						</div>
						<div class="form-group sm-col-span-12 lg-col-span-4">
							<label>
								<p>Ngày sinh</p>
							</label>
							<input type="date" name="date" value="{{$student->birthday}}">
						</div>
						<div class="form-group sm-col-span-12 lg-col-span-4">
							<label>
								<p>Giới tính</p>
							</label>
							<div class="select-style">
								<i class="fas fa-chevron-down"></i>
								<select name="sex" id="sex">
								@if($student->gender == 'Nam')
									<option value="0">Nam</option>
									<option value="1">Nữ</option>
								@else
									<option value="1">Nữ</option>
									<option value="0">Nam</option>
								@endif
								</select>
							</div>
						</div>
						<div class="form-group sm-col-span-12 lg-col-span-4">
							<label>
								<p>Email</p>
							</label>
							<input type="email" value="{{Auth::user()->email}}" disabled>
						</div>
						<div class="form-group sm-col-span-12 lg-col-span-4">
							<label>
								<p>Tên đăng nhập</p>
							</label>
							<input type="text" value="{{Auth::user()->username}}" disabled="">
						</div>
						<div class="form-group sm-col-span-12 lg-col-span-4">
							<label>
								<p>Địa chỉ</p>
							</label>
							<input type="text" name="address" value="{{$student->address}}">
						</div>
						<div class="form-group sm-col-span-12 lg-col-span-4">
							<label>
								<p>Số điện thoại</p>
							</label>
							<input type="tel" name="phone" value="{{$student->phone}}">
							@if($errors->has('phone'))
							<div class="notify-error">
								{{$errors->first('phone')}}
							</div>
							@endif
						</div>
						@if($type->id_utype == 3)
						<div class="btn-group sm-col-span-12 lg-col-span-4">
							<div class="btn-login">
								<button type="submit">Cập nhật</button>
							</div>
						</div>
						@else 
						<div class="btn-group sm-col-span-12 lg-col-span-4">
							<a href="admin/login" class="link-admin">Cập nhật thông tin tại trang quản trị</a>
						</div>
						@endif
					</form>
					@elseif($page == 2)
					<div class="change-pass">
						
						@if(session('passerror'))
						<div class="alert alert-error">
							{{session('passerror')}}
						</div>
						@endif
						<form action="changepassword/{{Auth::user()->id}}" method="POST" class="form-register clear-fix">
							<h3>Cập nhật mật khẩu</h3>
							<input type="hidden" name="_token" value="{{csrf_token()}}">
							<div class="form-group sm-col-span-12 lg-col-span-4">
								<label>
									<p>Nhập mật khẩu hiên tại</p>
								</label>
								<input type="password" id="pass" name="pass">
							</div>
							<div class="form-group sm-col-span-12 lg-col-span-4">
								<label>
									<p>Mật khẩu mới</p>
								</label>
								<input type="password" id="newpass" name="newpass">
							</div>
							<div class="form-group sm-col-span-12 lg-col-span-4">
								<label>
									<p>Xác nhận lại mật khẩu</p>
								</label>
								<input type="password" id="rNewpass" name="cfpass">
							</div>
							<div class="btn-group sm-col-span-12 lg-col-span-4">
								<div class="btn-login">
									<button id="submit-pass">Xác nhận</button>
								</div>
							</div>
						</form>
					</div>
					@else 
					@endif
					@endif
				</div>
				@endif
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
			}else {
				var $page = 2;
			}
			var $id = $('input[name=id]').val();
			console.log($page);
			
			$.ajax({
			url: 'profile/' + $id,
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
<!-- <script src="js/page-index.js"></script> -->
@endsection