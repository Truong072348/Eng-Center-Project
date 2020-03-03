@extends('pages.index')
@section('style')
<link rel="stylesheet" type="text/css" href="{{ secure_asset('css/page-intro.css') }}">
<link rel="stylesheet" type="text/css" href="{{ secure_asset('css/page-pay.css') }}">
<!-- <link rel="stylesheet" type="text/css" href="css/page-intro.css"> -->
<!-- <link rel="stylesheet" type="text/css" href="css/page-pay.css"> -->
@endsection
@section('content')
<div class="container">
	<div class="course-introduct">
		<div class="row-course">
			<div class="wr-left">
				<div class="course">
					<div class="course-content-wr">
						<h1 class="course-title-wr">{{$course->name}}</h1>
						<div class="course-category">
							@foreach($typeCList as $type)
							@if($type->id == $course->id_ctype)
							@foreach($categoryList as $cate)
							@if($cate->id == $type->id_category)
							<span>{{$cate->name}}</span> ||
							@endif
							@endforeach
							<span>{{$type->level}}</span>
							@endif
							@endforeach
						</div>
						<p class="course-intro">{{$course->description}}</p>
						<div class="course-teacher">
							Giáo viên: <a href="giao-vien/{{$teacher->id}}">{{$teacher->name}}</a>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="wr-right">
			<div class="pay">
				<div class="img-course">
					<img src="{{$course->img}}">
					<a href="course/{{$course->slug}}">Review this course</a>
				</div>
				<div class="course-t">
					<form method="POST" action="payment/{{$course->id}}" id="form-payment">
						<input type="hidden" name="_token" value="{{csrf_token()}}">
						@php($price = number_format($course->price, 0, '', '.'))
						<p class="course-hp">Giá: <span id="price">{{$price}}</span></p>
						@if(session('sale'))
						@php($sale = number_format(session('sale'), 0, '', '.'))
						<p id="sale">Giảm giá: <span>{{$sale}}</span></p>
						@endif
						<p id="total">Tổng: <span></span></p>
						<input type="hidden" name="price" value="{{$course->price}}">
						<input type="hidden" name="sale" value="{{session('name')}}">
						<input type="hidden" name="psale" value="{{session('sale')}}">
						<input type="hidden" name="idcoupon">
						<div class="course-buy">
							@if(Auth::check())
								<button id="payment">Thanh toán</button>
							@else
								<a id="paylogin">Thanh toán</a>
							@endif
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
	<div class="coup">
		<p>Nhập mã giảm giá để nhận các ưu đãi khóa học</p>
	</div>
	<div class="sale">
		@if(session('sale'))
		@php($reduce = number_format(session('sale'), 0, '', '.'))
		<div class="alert alert-success">
			Nhập mã giảm giá <span id="idcoupon">{{session('name')}}</span> thành công. Giảm {{$reduce}} đồng.
		</div>
		@endif
		@if(session('err'))
		<div class="alert alert-error">
			{{session('err')}}
		</div>
		@endif
		<form method="POST" action="discount">
			<input type="hidden" name="_token" value="{{csrf_token()}}">
			<div class="form-group-1">
				<label>Mã giảm giá</label>
				<input type="text" name="coupon">
				@if($errors->has('coupon'))
				<div class="notify-error">
					{{$errors->first('coupon')}}
				</div>
				@endif
				@if(session('time'))
				<div class="notify-error">
					{{session('time')}}
				</div>
				@endif
			</div>
			<div class="btn-group-1">
				<button type="submit">Nhập</button>
			</div>
		</form>
	</div>
	<div class="sale sale-row-2">
		<div class="info-sale">
			<h3>Thông tin khóa học</h3>
			<table>
				<tbody>
					<tr>
						<td class="tr-h"><img src="Images/lesson-p.png">Số bài giảng:</td>
						<td>Dang Cap Nhat</td>
					</tr>
					<tr>
						<td class="tr-h"><img src="Images/test-p.png">Số bài kiểm tra:</td>
						<td>Dang Cap Nhat</td>
					</tr>
					<tr>
						<td class="tr-h"><img src="Images/clock-p.png">Thời gian bắt đầu:</td>
						<td>{{$course->date_start}}</td>					
					</tr>
					<tr>
						<td class="tr-h"><img src="Images/clock-p.png">Thời gian kết thúc:</td>
						<td>{{$course->date_finish}}</td>
					</tr>
				</tbody>
			</table>
			<span>* Thời gian bắt đầu và kết thúc có thể được điều chỉnh cho phù hợp</span>
		</div>
	</div>
	<div class="modal" id="ex4" >
		<p>Tài khoản không đủ để thanh toán.</p>
		<a class="out-submit" id="inLogin" href="nap-tien/{{Auth::id()}}">Nạp tiền vào tài khoản</a>
	</div> 
</div>
@endsection
@section('script')
<script type="text/javascript">
	$(document).ready(function(){
		$(document).on('click', '#paylogin', function(){
			$('.modal').modal('open');
		});
	});

	var $idcoupon = $('#idcoupon').text();
	$('input[name=idcoupon]').val($idcoupon);

	$(window).on('load', function(){
		var $sale = $('input[name=psale]').val();
		var $price = $('input[name=price]').val();
		var $total = ($price - $sale).toLocaleString("en");

		$('#total span').html($total);

	});
</script>
<script src="{{ secure_asset('js/page-index.js') }}"></script>
<!-- <script src="js/page-index.js"></script> -->
@endsection