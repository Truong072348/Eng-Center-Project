<!DOCTYPE html>
<html>
	<head>
		<title>index</title>
		<meta charset="utf-8">
		<base href="{{asset('')}}">
		<meta name="viewport" content="width=device-width,initial-scale=1">
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
		<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.5.0/Chart.min.js"></script>
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-modal/0.9.1/jquery.modal.min.css" />
		<link rel="stylesheet" type="text/css" href="css/admin.css">
		<link rel="stylesheet" type="text/css" href="css/teacher.css">
		<link rel="stylesheet" type="text/css" href="css/question.css">
		@yield('style')
	
	</head>
	<body>
		<div class="wr">
			<div class="slide-left">
				@include('admin.layout.sidebar')
			</div>
			<div class="all-content-wr">
				@include('admin.layout.header')
				
				@yield('breadbrum')

				@yield('title')

				@yield('search')
				<div class="content-show">
					@yield('content')

					<!-- @yield('pagination') -->
				</div>
				<div class="team">
					<p><span>DLD English Center</span> | <span>&copy; 2019, Design by DLD Team</span></p>
				</div>
				
			</div>
		</div>


		@include('admin.layout.footer')
		<!--------chart------------->
		<script src="js/admin.js"></script>
		<script src="{{asset('ckeditor/ckeditor.js')}}"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-modal/0.9.1/jquery.modal.min.js"></script>
		<script src="js/sort-table.js"></script>
		
		@yield('script')
	</body>
</html>