@extends('pages.index')
@section('style')
<link rel="stylesheet" type="text/css" href="{{ secure_asset('css/page-account.css') }}">
<link rel="stylesheet" type="text/css" href="css/page-account.css">
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
							<li><img src="Images/degree-p.png"> Trình độ <p>{{$student->degree}}</p></li>
							<li><img src="Images/book-p.png"> Học vị<p>Đang cập nhật</p></li>
							<li><img src="Images/mail-p.png"> Email <p>{{$user->email}}</p></li>
							<li><img src="Images/facebook-p.png"> Facebook <p>fb.com</p></li>
						</ul>
					</nav>
				</div>
				<div class="acc-info-right">
					<h3>Thông tin cá nhân</h3>
						<input type="hidden" name="_token" value="{{csrf_token()}}">
						<div class="form-group sm-col-span-12 lg-col-span-4">
							<label>
								<p>Họ tên</p>
							</label>
							{{$student->name}}
						</div>
						<div class="form-group sm-col-span-12 lg-col-span-4">
							<label>
								<p>Ngày sinh</p>
							</label>
							{{$student->birth}}
						</div>
						<div class="form-group sm-col-span-12 lg-col-span-4">
							<label>
								<p>Giới tính</p>
							</label>
							{{$student->gender}}
						</div>
						<div class="form-group sm-col-span-12 lg-col-span-4">
							<label>
								<p>Địa chỉ</p>
							</label>
							{{$student->address}}
						</div>
						<div class="form-group sm-col-span-12 lg-col-span-4">
							<label>
								<p>Số điện thoại</p>
							</label>
							{{$student->phone}}
						</div>
					</div>
				</div>
			</div>
		</div>
		<div>
			

		</div>
	</div>
</div>
@endsection
@section('script')

<script src="{{ secure_asset('js/page-index.js') }}"></script>
<script src="js/page-index.js"></script>
@endsection