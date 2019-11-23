$(document).ready(function(){
	$('.dr-child').hide();
	$('.menu').on("click", function(){
		$(this).next('.dr-child').slideToggle('medium');
	});

	$('.menu-dr').on("click", function(){
		$(this).toggleClass('active');
		$(this).next('.menu-left-child').slideToggle('medium');
	});

	/*menu bar*/
	$('#menu-bar').on("click", function(){
		var show = $('.slide-menu-wr nav').css("display");
		
		if(show != "none"){
			$('.slide-menu-wr nav').hide('fast');
		} else {
			$('.slide-menu-wr nav').show('fast');
		}
	});



});
