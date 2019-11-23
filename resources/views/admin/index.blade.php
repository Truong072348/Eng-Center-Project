@extends('admin.layout.index')
@section('style')
<link rel="stylesheet" type="text/css" href="css/dashboard.css">
@endsection
@section('breadbrum')
<div class="breadcrumb">
	<ul class="clear-fix">
		<li><i class="fas fa-home"></i> Dashboard</li>
	</ul>
</div>
@endsection
@section('title')
<div class="page-title">
	<h1><img src="Images/folder.png">Dashboard</h1>
</div>
@endsection
@section('content')
<div class="count-wr">
	<div class="count-student">
		<div class="desc">
			<div class="info">
				<span class="count">{{$studentList->count()}}</span>
				<span class="name">Total Student</span>
			</div>
			<img src="Images/user.png">
		</div>
	</div>
	<div class="count-teacher">
		<div class="desc">
			<div class="info">
				<span class="count">{{$teacherList->count()}}</span>
				<span class="name">Total Teacher</span>
			</div>
			<img src="Images/teacher-blue.png">
		</div>
	</div>
	<div class="count-class">
		<div class="desc">
			<div class="info">
				<span class="count">{{$courseTotal->count()}}</span>
				<span class="name">Total Courses</span>
			</div>
			<img src="Images/video-player.png">
		</div>
	</div>
	<div class="count-document">
		<div class="desc">
			<div class="info">
				<span class="count">{{$testList->count()}}</span>
				<span class="name">total Document</span>
			</div>
			<img src="Images/record.png">
		</div>
	</div>
</div>
<div class="container-chart">
	<canvas id="myChart"></canvas>
</div>
@endsection
@section('script')
<script src="js/chart.js"></script>
@endsection