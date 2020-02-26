@extends('layout.index')
@section('style')
<link rel="stylesheet" type="text/css" href="{{ secure_asset('css/index.css') }}">
<!-- <link rel="stylesheet" type="text/css" href="css/index.css"> -->
<link rel="stylesheet" type="text/css" href="{{ secure_asset('css/page-list.css') }}">
<!-- <link rel="stylesheet" type="text/css" href="css/page-list.css"> -->
<style type="text/css">
	.intro-wr  {
		margin-top: -30em;
	}

	.box-intro {
		padding: 3em 1.5em;
	}

	.container-course {
		display: block !important;
	}
	.course {
		padding: 15px;
		
	}

	.course-c {
		border-bottom:1px solid;
	}
	
	@media screen and (min-width: 992px) { 
		.course {
			width: 25%;
	}

	@media screen and (max-width: 991px) { 
		.course {
			width: 33.3%;
	}

</style>
@endsection

@section('content')
<div class="wrapper">
	<div class="row">
		<div class="slider" id="slider">
			<div class="slide one">
				<img src="./Images/banner-7.jpg">
			</div>
			<div class="slide two">
				<img src="./Images/banner-2.png">
			</div>
			<div class="slide three">
				<img src="./Images/banner-3.png">
			</div>
		</div>
	</div>
	<div class="row">
		<div class="container clear-fix">
			<div class="sm-col-span-4 md-col-span-8 lg-col-span-4">
				<div class="intro-wr">
					<div class="intro">
						<div class="box-intro">
							<span class="icon">
								<img src="./Images/icon-book.png">
							</span>
							<div class="intro">
								
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="container-course">
			<div class="course-title">
				<h2>Our Teacher</h2>
				<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.</p>
			</div>
			<div class="course-wr">
				@if(isset($lsteacher))
				@foreach($lsteacher as $t)
				<div class="course">
					<div class="course-img">
						<a href="giao-vien/{{$t->id}}">
							<img src="{{$t->img}}">
						</a>
					</div>
					<div class="course-c">
						Teacher
						<p class="course-title">
							 <span>{{$t->name}}</span>
						</p>
						<p class="course-desc">{{$t->slogan}}</p>
						<a href="giao-vien/{{$t->id}}">Learn more</a>
					</div>
				</div>
				@endforeach
				@endif
			</div>
			
		</div>
	</div>
</div>
@endsection

@section('script')
<script src="{{ secure_asset('js/page-index.js') }}"></script>
<!-- <script src="js/page-index.js"></script> -->
@endsection