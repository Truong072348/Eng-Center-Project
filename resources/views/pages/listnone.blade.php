@extends('layout.index')
@section('style')
<link rel="stylesheet" type="text/css" href="{{ secure_asset('css/index.css') }}">
<!-- <link rel="stylesheet" type="text/css" href="css/index.css"> -->
<link rel="stylesheet" type="text/css" href="{{ secure_asset('css/page-list.css') }}">
<!-- <link rel="stylesheet" type="text/css" href="css/page-list.css"> -->
@endsection

@section('content')
<div class="wrapper">
		<div class="row">
			<div class="breadcrumb-wr">
				<nav>
					<ul class="breadcrumb clear-fix">
						<li><a href="Home"><i class="fas fa-home"></i> Trang chủ</a></li>
						<li>Khóa học</li>
					</ul>
				</nav>
			</div>
		</div>
		<div class="row">
			<div class="total-wr">
				<h1>Course</h1>

			</div>
			<div class="sm-col-span-3 menu-left">
				<nav class="nav-menu-left">
					<ul class="sidebar clear-fix">
						<li>
							<div class="side-title">
								DOCUMENT
							</div>
							<ul class="side clear-fix">
								@foreach($categoryList as $category)
								<li><a href="Danh-sach/{{$category->name}}">{{$category->name}}</a></li>
								@endforeach
							</ul>
						</li>
						<li>
							<div class="side-title">
								TEST
							</div>
							<ul class="side clear-fix">
								@foreach($categoryList as $category)
								<li><a href="Danh-sach/{{$category->name}}">{{$category->name}}</a></li>
								@endforeach
							</ul>
						</li>
						@foreach($categoryList as $category)
						<li>
							<div class="side-title dropdown-menu">
								<a href="Danh-sach/{{$category->name}}">{{$category->name}}<i class="fas fa-chevron-right"></i></a>
							</div>
							<ul class="side clear-fix">
								@foreach($typeCList as $type)
								@if($type->id_category == $category->id)
								<li><a href="Danh-muc/{{$type->slug}}">{{$type->level}}</a></li>
								@endif
								@endforeach
							</ul>
						</li>
						@endforeach
					</ul>
				</nav>
			</div>
			<div class="sm-col-span-8 md-col-span-8 lg-col-span-4 content">
				@if(isset($courseSearch))
					{{$courseSearch}}
				@else
				<div class="container-course-wr">
					<!-- <p class="view" style="text-align: left; font-size: 16px "> Không tìm thấy khóa học </p> -->
					<div class="course-wr" style="width: 50%; margin: 0 auto">
						<img src="./Images/noresults.jpg">
					</div>
				</div>
				
				@endif
			</div>
		</div>
	</div>
@endsection

@section('script')
<script src="{{ secure_asset('js/page-index.js') }}"></script>
<!-- <script src="js/page-index.js"></script> -->
@endsection