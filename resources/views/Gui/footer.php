<footer>
	<div class="wrapper">
		<div class="row">
			<nav class="nav-footer clear-fix">
				<div class="sm-col-span-3 md-col-span-8 lg-col-span-4">
					<div class="footer-intro-website">
						<div class="footer-logo">
							<img src="./Images/logo-mobile.png">
							<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s</p>
						</div>
						<strong>Liên hệ hỗ trợ: 0123456789</strong>
					</div>
				</div>
				<div class="sm-col-span-3 md-col-span-8 lg-col-span-4">
					<div class="footer-title">
						QUY ĐỊNH
						<button class="dropdown-footer">
						<i class="fas fa-angle-down"></i>
						</button>
						<ul class="footer-menu clear-fix">
							<li><a href="#">Điều khoản sử dụng</a></li>
							<li><a href="#">Chính sách riêng tư</a></li>
							<li><a href="#">Bản quyền và chính sách nội dụng</a></li>
						</ul>
					</div>
				</div>
				<div class="sm-col-span-3 md-col-span-8 lg-col-span-4">
					<div class="footer-title">
						DỊCH VỤ
						<button class="dropdown-footer">
						<i class="fas fa-angle-down"></i>
						</button>
						<ul class="footer-menu clear-fix">
							<li><a href="#">Luyện thi Tiếng Anh</a></li>
							<li><a href="#">Đăng ký khóa học</a></li>
							<li><a href="#">Trao đổi tin tức</a></li>
						</ul>
					</div>
				</div>
				<div class="sm-col-span-3 md-col-span-8 lg-col-span-4">
					<div class="footer-title">
						HỖ TRỢ
						<button class="dropdown-footer">
						<i class="fas fa-angle-down"></i>
						</button>
						<ul class="footer-menu clear-fix">
							<li><a href="#">Thủ Đức, Tp HCM </a></li>
							<li><a href="#">Về DLD</a></li>
							<li><a href="#">Email: abc@gmail.com</a></li>
						</ul>
					</div>
				</div>
			</nav>
			<div class="copy sm-col-span-12">
				<p>Copyright&copy; 2019-VN This project was made by DLD team</p>
				<span>Demo Images <a href="https://www.designevo.com/logo-make">Logo Market</a><a href="https://www.pexels.com/">Pexels</a> </span>
				<div class="icon-group">
					<ul>
						<li><a href="#"><i class="fab fa-facebook-f"></i></a></li>
						<li><a href="#"><i class="fab fa-google"></i></a></li>
						<li><a href="#"><i class="fab fa-youtube"></i></i></a></li>
					</ul>
				</div>
			</div>
		</div>
	</div>
</footer>
<script>
		var x = document.getElementsByClassName('dropdown-footer');
		var i;
		for (i = 0; i < x.length; i++) {
		    x[i].addEventListener('click', function() {

		        $(this).next('.footer-menu').slideToggle("medium");

		    });
		}
	</script>
	<!--JQuery min 3.4.0-->
	<script src="javascript/jquery-3.4.0.min.js"></script>
	<!--Event header---->
	<script src="javascript/header.js"></script>