
$(document).ready(function(){

	// Scroll top event
	$(window).scroll(function(){
		if($(this).scrollTop() > 100){
			$('.scrollTop').fadeIn();
		}else{
			$('.scrollTop').fadeOut();
		}
	});

	$('.scrollTop').click(function(){
		$('html, body').animate({scrollTop : 0}, 600);
		return false;
	});


	//Event click outside menu
	var $window = $(window);
	var windowWidth = $window.width();

	if(windowWidth > 991) {
		$(".basic-icon-menu").click(function(){
			$('.basic-dropdown').slideToggle("medium");
		});

		$(document).click(function(e){
			e.stopPropagation();
			var container = $(".nav-menu-bs");
			//check if the clicked area is dropDown or not
			if (container.has(e.target).length === 0) {
				$('.basic-dropdown').hide();
			}
		});
	}

	if (windowWidth <= 991) {
		$(".basic-icon-menu").click(function(){
			$('.basic-dropdown').toggle("slide");
		});

		$('.basic-dropdown li h3').click(function(){
			$(this).next('.basic-dropdown-child').slideToggle("medium");
		});

		$(document).click(function(e){
			e.stopPropagation();
			var container = $(".nav-menu-bs");
			//check if the clicked area is dropDown or not
			if (container.has(e.target).length === 0) {
				$('.basic-dropdown').hide();
			}
		});
	}
});