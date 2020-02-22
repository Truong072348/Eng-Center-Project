@extends('layout.index')
@section('style')
<link rel="stylesheet" type="text/css" href="{{ secure_asset('css/index.css') }}">
<link rel="stylesheet" type="text/css" href="{{ secure_asset('css/page-list.css') }}">
@endsection

@section('content')
<div class="wrapper">
		<div class="row">
			<div class="breadcrumb-wr">
				<nav>
					<ul class="breadcrumb clear-fix">
						<li><a href="index"><i class="fas fa-home"></i> Trang chủ</a></li>
						<li>Khóa học</li>
					</ul>
				</nav>
			</div>
		</div>
		<div class="row">
			<div class="total-wr">
				<h1>Course</h1>

				<p> ( {{count($courseList)}} Courses)</p> 
				<span id="keyword"> 
					@if(isset($name))
						{{$name->name}} :
					@else
						{{$key}} 
					@endif

					@foreach($typeCList as $type)
					@if($type->id == $key)
						{{$type->level}}
					@endif
					@endforeach
				</span>

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
								<li><a href="#">{{$category->name}}</a></li>
								@endforeach
							</ul>
						</li>
						<li>
							<div class="side-title">
								TEST
							</div>
							<ul class="side clear-fix">
								@foreach($categoryList as $category)
								<li><a href="#">{{$category->name}}</a></li>
								@endforeach
							</ul>
						</li>
						@foreach($categoryList as $category)
						<li>
							<div class="side-title dropdown-menu">
								<a href="list/{{$category->name}}">{{$category->name}}<i class="fas fa-chevron-right"></i></a>
							</div>
							<ul class="side clear-fix">
								@foreach($typeCList as $type)
								@if($type->id_category == $category->id)
								<li><a href="category/{{$type->id}}">{{$type->level}}</a></li>
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
					<p class="view">View 
						<span id="current">
							@if(count($courseList) > 0)
							{{$courseList->firstItem()}}
							@else 
								0
							@endif
						</span> 
						<span class="divider">|</span> 
						
						<span>
							@if(count($courseList) > 0)
								{{$courseList->lastItem()}}
							@else 
								0
							@endif
						</span>

					</p>
					<div class="course-wr">
						@if(count($courseList) > 0)
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
								<a href="course-detail.php">Learn more</a>
							</div>
						</div>
				
						@endforeach
						@endif
						
					</div>
				</div>
				@if(count($courseList) > 0)
				<div class="sm-col-span-12 lg-col-span-4">
					<div class="pagination-wr">
						{{$courseList->links()}}
					</div>
				</div>
				@endif
				@endif
			</div>
		</div>
	</div>
@endsection

@section('script')
<script src="{{ secure_asset('js/page-index.js') }}"></script>
@endsection