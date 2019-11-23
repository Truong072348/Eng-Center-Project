<div class="header-fix">
	<div class="header-wr">
		<h2>DLD English Center</h2>
	</div>
	<div class="info-wr-right">
		<ul class="dr-menu clear-fix">
			<li><a href="#"><img src="./Images/mail.png"></a></li>
			<li><a href="#"><img src="./Images/bell.png"></a></li>
			@if(Auth::check())
			<li class="account">
				<div class="menu acount-head">
					<img src="./Images/my-avatar.jpg">
					Hello, <span>{{Auth::user()->username}}</span>
				</div>
				<ul class="dr-child child">
					@if(Auth::user()->id_utype != 1)
					<li><a href="admin/teacher/edit/{{Auth::user()->id}}">My Profile</a></li>
					@endif
					<li><a href="#">Setting</a></li>
					<li><a href="admin/login">Logout</a></li>
				</ul>
			</li>
			@endif
		</ul>
	</div>
</div>