$(document).ready(function(){
	
	//Event Slider
	// var options = {
	//		 slides: '.slide', // The name of a slide in the slidesContainer
	//       swipe: false,    // Add possibility to Swipe > note that you have to include touchSwipe for this
	//       transition: "slide", // Accepts "slide" and "fade" for a slide or fade transition
	//       slideTracker: true, // Add a UL with list items to track the current slide
	//       slideTrackerID: 'slideposition', // The name of the UL that tracks the slides
	//       slideOnInterval: false, // Slide on interval
	//       interval: 9000, // Interval to slide on if slideOnInterval is enabled
	//       animateDuration: 1000, // Duration of an animation
	//       animationEasing: 'ease', // Accepts: linear ease in out in-out snap easeOutCubic easeInOutCubic easeInCirc easeOutCirc easeInOutCirc easeInExpo easeOutExpo easeInOutExpo easeInQuad easeOutQuad easeInOutQuad easeInQuart easeOutQuart easeInOutQuart easeInQuint easeOutQuint easeInOutQuint easeInSine easeOutSine easeInOutSine easeInBack easeOutBack easeInOutBack
	//       pauseOnHover: false, // Pause when user hovers the slide container
	//       magneticSwipe: true, // This will attach the slides to the mouse's position when swiping/dragging
	//       neverEnding: true // Enable this to create a 'neverending' effect.
	// }
	var options = {
		interval: 9000,
		animateDuration: 1000
	}

	$('.slider').simpleSlider(options);

	//Animation text in slider
	$(".slider").on("beforeSliding", function(event){
		var prevSlide = event.prevSlide;
		var newSlide = event.newSlide;
		$(".slider .slide[data-index='" + prevSlide + "'] .slidecontent").removeClass('active');
		$(".slider .slide[data-index='" + newSlide + "'] .slidecontent").toggleClass('active');
	});

	// Event menu dropdown 
	$(".panel-content").hide();
	$(".btn-panel").each(function(index){
		$(this).on("click", function(){
			var sibling = $(this).parents(".panel-heading").siblings(".panel-content");
			var panel = $(this);
			$(".panel-content").each(function(){
				if(!$(this).is(sibling)){
					$(this).removeClass("in");
					$(this).hide(500);
				}
			})
			$(this).parents(".panel-heading").siblings(".panel-content").slideToggle("medium");
			$(".btn-panel").each(function(){
				if(!$(this).is(panel)){
					$(this).removeClass("in");
				}
			})
			$(this).toggleClass("in");
		});
	});
	

	$('.container-service').hide();
	$('.container-counter').hide();

	//Event change position img when scroll and show ele hide
	$(window).scroll(function(){
		var x = $(this).scrollTop();
		$('.counter-img').css('background-position', '0%' + parseInt(x / 10) + '%');

		if(x > 500) {
			$('.container-service').fadeIn(2000);
		}

		if (x > 1000) {
			$('.container-counter').fadeIn(1000);
		}

	});

});