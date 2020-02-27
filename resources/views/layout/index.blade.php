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
		<!-- <link rel="stylesheet" type="text/css" href="{{ secure_asset('css/wrap.css') }}"> -->
		<!-- <link rel="stylesheet" type="text/css" href="{{ secure_asset('css/page-login.css') }}"> -->
		<link rel="stylesheet" type="text/css" href="css/wrap.css">
		
		<link rel="stylesheet" type="text/css" href="css/page-login.css">
		@yield('style')
	
	</head>
	<body>
		@include('layout.header')
				
			@yield('content')
				
		@include('layout.footer')
		<!--------chart------------->

		@yield('script')
		<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-modal/0.9.1/jquery.modal.min.js"></script>
	

		@if (session('openLogin'))
		<script type="text/javascript">
			$('#ex1').modal('open');
		</script>
		@endif

		@if(session('openSuccessReg'))
			<script>
				$('#ex1').modal('open');
			</script>
		@endif

		@if(!session('openRegister') || !session('openLogin'))	
			<script type="text/javascript">
				$('.tabs:not(:first)').addClass('inactive');
				$('.tab-form').hide();
				$('.tab-form:first').show();
			</script>
		@endif

		@if(session('pushCard'))
		<script>
			$('#ex4').modal('open');
		</script>
		@endif
		
		@if(session('page'))
		<script>
			$('.page').parent().removeClass('active');
			$('#page2').addClass('active')
		</script>
		@endif

		<script type="text/javascript">
			$(document).ready(function(){
				$(document).on('click', '.tabs', function(){
					var t = $(this).attr('id');
					if($(this).hasClass('inactive')){
						$('.tabs').addClass('inactive');
						$(this).removeClass('inactive');
						$('.tab-form').hide();
    					$('#'+ t + 'C').fadeIn('fast');
					}
				});
			});
		</script>

		@if(session('refail'))
		<script>
			$('.tabs').addClass('inactive');
		</script>
		@endif

		@if (session('openRegister'))
		<script>
			$('#ex1').modal('open');
			$('#tab1C').hide();
    		$('#tab2C').show();
    		$('.tabs-lg').addClass('inactive');	
    		$('.tabs-rg').removeClass('inactive');
		</script>
		@endif
	</body>
</html>