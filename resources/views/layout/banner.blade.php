<div class="row">
	<div class="sm-col-span-12 lg-col-span-4">
		<div class="banner-avatar">
			<div class="banner">
				<img src="./Images/banner-1.png">
			</div>
			<div class="avatar">
				<div id="circle">
					<!-- <input type="file" name="file" accept="*/"> -->
					<img src="./Images/{{$student->avatar}}">
					<!-- <div id="overlay"></div>	 -->
				</div>		
			</div>
			<div class="name-accout">
				<span>
					<a href="profile/{{Auth::user()->id}}">
						@if(isset($student))
							{{$student->name}}
						@else
							{{Auth::user()->username}}
						@endif
					</a>
				</span>
				<span><a href="#">(ID: {{Auth::user()->id}})</a></span>
			</div>
			<nav>
				<ul class="link-under-banner clear-fix">
					<li><a href="profile/{{Auth::user()->id}}">Thông tin cá nhân</a></li>
					<li><a href="account/{{Auth::user()->id}}">Thông tin tài khoản</a></li>
					<li><a href="#">Trợ giúp</a></li>
				</ul>
			</nav>
		</div>
	</div>
</div>