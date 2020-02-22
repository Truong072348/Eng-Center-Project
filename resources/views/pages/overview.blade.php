@extends('pages.index')
@section('style')
<link rel="stylesheet" type="text/css" href="{{ secure_asset('css/overview.css') }}">
<link rel="stylesheet" type="text/css" href="css/overview.css">
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
					<li>{{$test->name}}</li>
				</ul>
			</nav>
		</div>
	</div>
</div>
<div class="content-wr-intro">
	<h3><span>{{$course->name}}</span></h3>
	<div class="test-info">
		@if($tested == false)
		<table class="table">
			<tr>
				<td colspan="1"><div class="ts-info-title">{{$test->name}}</div></td>
			</tr>
			<tr>
				<td>Tổng số câu:  <span>{{count($listQuestion)*4 + count($listquestionBasic)}}</span></td>
			</tr>
			<tr>
				<td>Điểm số tối đa <span>10</span></td>
			</tr>
			<tr>
				<td>Thời gian làm bài <span>{{$info->time}}:00 phút</span></td>
			</tr>
		</table>
		<div class="start-test">
			<a href="test/{{$test->id}}">Bắt đầu kiểm tra</a>
		</div>
		@else 
		@if(isset($result))
			<table class="table">
				<tr>
					<td colspan="1"><div class="ts-info-title">{{$test->name}}</div></td>
				</tr>
				<tr>
					<td>Tổng số câu:  <span>{{count($listQuestion)*4 + count($listquestionBasic)}}</span></td>
				</tr>
				<tr>
					<td>Số câu đúng:  <span>{{$result->score}}</span></td>
				</tr>
				<tr>
					<td>Điểm số <span>{{$result->score / (count($listQuestion) * 4 + count($listquestionBasic))  * 10}}</span></td>
				</tr>
				<tr>
					<td>Thời gian còn lại <span>{{$result->time}} phút</span></td>
				</tr>
			</table>
			<a href="review/{{$test->id}}">Xem lại kết quả</a>
		@endif
		@endif
	</div>
</div>
@endsection
@section('script')
<script src="{{ secure_asset('js/page-index.js') }}"></script>
<script src="js/page-index.js"></script>

@endsection