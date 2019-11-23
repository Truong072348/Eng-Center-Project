<!DOCTYPE html>
<html>
	<head>
		<title>Login</title>
		<title>index</title>
		<meta charset="utf-8">
		<base href="{{asset('')}}">
		<meta name="viewport" content="width=device-width,initial-scale=1">
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
		<link rel="stylesheet" type="text/css" href="css/login.css">
		<!-- <link rel="stylesheet" type="text/css" href="css/wrap.css"> -->
	</head>
	<body>
		<div class="wrapper">
			<div class="row">
				<div class="content">
					<div class="form">
						<img src="Images/logo-mobile.png">
						<h2>Đăng nhập</h2>
						@if(count($errors) > 0)
						<div class="alert alert-error">
							Vui lòng điền đầy đủ thông tin.
						</div>
						@endif
						@if(session('error'))
						<div class="alert alert-error">
							{{session('error')}}
						</div>
						@endif
						<form action="admin/login" method="POST" class="form-login">
							<input type="hidden" name="_token" value="{{csrf_token()}}">
							<div class="form-group">
								<label>
									<p>Username</p>
								</label>
								<input type="text" name="username">
							</div>
							<div class="form-group">
								<label>
									<p>Password</p>
								</label>
								<input type="password" name="password">
							</div>
							
							<div class="btn-group">
								<button type="submit">Đăng nhập</button>
							</div>
							
							<div class="links">
								<a href="#" class="fgpass sm-col-span-12 lg-col-span-4">Quên mật khẩu?</a>
								
							</div>
						</form>
					</div>
					<div class="intro-right">
						<div class="intro">
							<h2>Hello, Friend!</h2>
							<p>Enter your personal details and start journey with us</p>
						</div>
					</div>
				</div>
			</div>
		</div>
	</body>
</html>