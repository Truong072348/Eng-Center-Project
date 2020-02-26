<header>
	<div class="wrapper">
		<div class="row">
			<div class="sm-col-span-12 lg-col-span-4">
				<div class="nav-header-wr">
					<div class="header-top" id="top">
						<ul class="nav-top clear-fix">
							<li><i class="fas fa-phone"></i>Hotline: 123.456.789</li>
							<li><i class="fas fa-envelope"></i>abc@gmail.com</li>
							<li><a href="https://www.facebook.com/PainLe12" target="_blank"><i class="fab fa-facebook-f"></i></a></li>
							<li><a><i class="fab fa-twitter"></i></a></li>
							<li><a><i class="fab fa-youtube"></i></a></li>
							<li><a href="help" rel="modal:open">Giúp đỡ</a></li>
							<li><a href="about">Về chúng tôi</a></li>
							@if(Auth::check())
							<li class="dropdown-acc">
								<a>Hello, {{Auth::user()->username}} <img src="Images/user-w.png"></a>
								<ul class="clear-fix dropdown-child-acc">
									@if(Auth::user()->id_utype == 1)
									<li><a href="admin/dashboard">Trang quản trị</a></li>
									@elseif(Auth::user()->id_utype == 2)
									<li><a href="profile/{{Auth::user()->id}}">Hồ sơ</a></li>
									<li><a href="account/{{Auth::user()->id}}">Lịch sử giao dịch</a></li>
									<li><a href="admin/dashboard">Trang quản trị</a></li>
									@else
									<li><a href="profile/{{Auth::user()->id}}">Hồ sơ</a></li>
									<li><a href="account/{{Auth::user()->id}}">Lịch sử giao dịch</a></li>
									@endif
									<li><a href="logout">Thoát tài khoản</a></li>
									
								</ul>
							</li>
							@else
							<li><a href="#ex1" rel="modal:open">Đăng nhập</a></li>
							@endif
						</ul>
						<div id="ex1" class="modal">
							<div class="content">
								<div class="intro-left">
									<div class="intro">
										<h2>Hello, Friend!</h2>
										<p>Enter your personal details and start journey with us</p>
									</div>
									<div class="img-modal">
										<img src="Images/globe.png">
									</div>
								</div>
								<div class="form-l">
									<div class="tabs-group">
										<div class="tabs tabs-lg" id="tab1">
											Đăng nhập
										</div>
										<div class="tabs tabs-rg" id="tab2">
											Tạo tài khoản
										</div>
									</div>
									<form action="login" method="POST" class="tab-form form-login" id="tab1C">
										@if(session('message'))
										<div class="notify-error">
											{{session('message')}}
										</div>
										@endif
										@if(session('regSuccess'))
										<div class="alert notify-success">
											{{session('regSuccess')}}
										</div>
										@endif
										<input type="hidden" name="_token" value="{{csrf_token()}}">
										<div class="form-group-l">
											<label>
												<p>Tài khoản</p>
											</label>
											<input type="text" name="username">
											@if($errors->has('username'))
											<div class="notify-error">
												{{$errors->first('username')}}
											</div>
											@endif
										</div>
										<div class="form-group-l">
											<label>
												<p>Mật khẩu</p>
											</label>
											<input type="password" name="password" placeholder="Mật khẩu từ 3 đến 32 ký tự">
											@if($errors->has('password'))
											<div class="notify-error">
												{{$errors->first('password')}}
											</div>
											@endif
										</div>
										
										<div class="btn-group-l">
											<div class="links">
												Quên mật khẩu? Nhấp vào
												<a href="#" class="fgpass">đây</a>
												
											</div>
											<button type="submit">Đăng nhập</button>
										</div>
										
									</form>
									<form action="register" method="POST" class="tab-form form-login" id="tab2C">
										<input type="hidden" name="_token" value="{{csrf_token()}}">
										<p id="intro">Đăng ký ngay hôm nay đễ nhận ưu đãi các khóa học miễn phí từ DLD</p>
										<div class="form-group-l">
											<label>
												<p>Họ tên</p>
											</label>
											<input type="text" name="name" placeholder="Nhập họ tên" value="{{old('name')}}">
											@if($errors->has('name'))
											<div class="notify-error">
												{{$errors->first('name')}}
											</div>
											@endif
										</div>
									
										<div class="form-group-l">
											<label>
												<p>SĐT</p>
											</label>
											<input type="tel" name="phone" placeholder="Nhập số điện thoại" value="{{old('phone')}}">
											@if($errors->has('phone'))
											<div class="notify-error">
												{{$errors->first('phone')}}
											</div>
											@endif
										</div>
										<div class="form-group-l">
											<label>
												<p>Địa chỉ</p>
											</label>
											<input type="text" name="address" placeholder="Nhập địa chỉ" value="{{old('address')}}">
											@if($errors->has('address'))
											<div class="notify-error">
												{{$errors->first('address')}}
											</div>
											@endif
										</div>
										<div class="form-group-l">
											<label>
												<p>Email</p>
											</label>
											<input type="email" name="email" placeholder="Nhập email">
											@if($errors->has('email'))
											<div class="notify-error">
												{{$errors->first('email')}}
											</div>
											@endif
										</div>
										<div class="form-group-l">
											<label>
												<p>Tên đăng nhập</p>
											</label>
											<input type="text" name="user" placeholder="Nhập tên đăng nhập">
											@if($errors->has('user'))
											<div class="notify-error">
												{{$errors->first('user')}}
											</div>
											@endif
										</div>
										<div class="form-group-l">
											<label>
												<p>Mật khẩu</p>
											</label>
											<input type="password" name="pass" placeholder="Mật khẩu từ 3 đến 32 ký tự">
											@if($errors->has('pass'))
											<div class="notify-error">
												{{$errors->first('pass')}}
											</div>
											@endif
										</div>

										
										<div class="btn-group-l">
											<button type="submit">Tạo tài khoản</button>
										</div>
										
									</form>
									
								</div>
							</div>
						</div>
					</div>
					<div class="header-bottom">
						<div class="nav-menu-bs">
							<div class="basic-icon-menu">
								<i class="fas fa-bars"> </i><span>Danh Mục</span>
							</div>
							<ul class="basic-dropdown" id="bs-menu">
								<li>
									<h3>Khóa học</h3>
									<ul class="basic-dropdown-child">
										@if(isset($categoryList))
										@foreach($categoryList as $cate)
										<li><a href="Danh-sach/{{$cate->name}}">Khóa học {{$cate->name}}</a></li>
										@endforeach
										@endif
									</ul>
								</li>
								<li>
									<h3>Giáo viên</h3>
									<ul class="basic-dropdown-child">
										<li><a href="danh-sach-giao-vien">Thông tin giáo viên</a></li>
									</ul>
								</li>
								<li>
									<h3>Học phí</h3>
									<ul class="basic-dropdown-child">
										<li><a>Khuyến mãi</a></li>
									</ul>
								</li>
								<li>
									<h3>Phòng thi</h3>
									<ul class="basic-dropdown-child">
										<li><a>Tự luyện</a></li>
										<li><a>Đánh giá năng lực</a></li>
									</ul>
								</li>
							</ul>
						</div>
						<div class="logo-center">
							<a href="Home"><img src="./Images/logo-mobile.png"></a>
						</div>
						<div class="hr-search">
							<form class="bs-search-form" method="POST" action="search">
								<input type="hidden" name="_token" value="{{csrf_token()}}">
								<input type="text" placeholder="Tìm kiếm..." name="search">
								<button type="submit"><i class="fas fa-search"></i></button>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<a class="scrollTop"><i class="fas fa-angle-up"></i></a>
</header>