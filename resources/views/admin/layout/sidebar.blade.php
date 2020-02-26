<nav class="slidebar">
	<div class="slidebar-header">
		<div class="header-logo">
			<a href="admin/index">
				<img src="./Images/logo-mobile.png">
			</a>
		</div>
		<div class="icon-menu">
			<span id="menu-header">
				<img src="./Images/menu.png">
			</span>
		</div>
	</div>
	<div class="slide-menu-wr">
		<div class="menu-mobile">
			<span>MENU</span>
			<a class="icon-bar" id="menu-bar"><i class="fas fa-bars"></i></a>
		</div>
		<!-- <div class="scroll-content"> -->
		<nav>
			<ul class="menu-left clear-fix">
				@if(Auth::user()->id_utype == 1)
				<li>
					<a href="admin/dashboard" class="menu-dr">
						<img src="./Images/home.png">
						<span>Dashboard</span>
					</a>
				</li>
				<li>
					<a href="admin/account/list" class="menu-dr">
						<img src="./Images/science.png">
						<span>Account</span>
					</a>
					
				</li>
				<li>
					<a href="admin/teacher/list" class="menu-dr">
						<img src="./Images/professor.png">
						<span>Teacher</span>
					</a>
					
				</li>
				<li>
					<a href="admin/student/list" class="menu-dr">
						<img src="./Images/student-g.png">
						<span>Student</span>
					</a>
					
				</li>
				<li>
					<a href="admin/course/list" class="menu-dr">
						<img src="./Images/science.png">
						<span>Course</span>
					</a>
					
				</li>
				<li>
					<a href="admin/question/list" class="menu-dr">
						<img src="./Images/science.png">
						<span>Question</span>
					</a>
					
				</li>
				
				<li>
					<a href="admin/test/list" class="menu-dr">
						<img src="./Images/science.png">
						<span>Test</span>
					</a>
					
				</li>
				<li>
					<a  class="menu-dr">
						<img src="./Images/data.png">
						<span>Pages</span>
					</a>
					<ul class="menu-left-child">
						<li><a href="#">Dashboard 1</a></li>
						<li><a href="#">Dashboard 2</a></li>
						<li><a href="#">Dashboard 3</a></li>
					</ul>
				</li>
				@else 
				<li>
					<a href="admin/index" class="menu-dr">
						<img src="./Images/home.png">
						<span>Dashboard</span>
					</a>
				</li>
				<li>
					<a href="admin/question/list" class="menu-dr">
						<img src="./Images/science.png">
						<span>Question</span>
					</a>
					
				</li>
				
				<li>
					<a href="admin/test/list" class="menu-dr">
						<img src="./Images/science.png">
						<span>Test</span>
					</a>
					
				</li>
				@endif

			</ul>
		</nav>
	</div>
</nav>