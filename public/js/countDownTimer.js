$(document).ready(function(){
	
		// $('#btn-start').click(function(){
			var timer2 = "30:00";
			var interval = setInterval(function() {


			  var timer = timer2.split(':');
		
			  var minutes = parseInt(timer[0], 10);
			  var seconds = parseInt(timer[1], 10);
			  --seconds;

			  minutes = (seconds < 0) ? --minutes : minutes;
			  seconds = (seconds < 0) ? 59 : seconds;
			  seconds = (seconds < 10) ? '0' + seconds : seconds;
			
			  $('.time-test span').html(minutes + ':' + seconds);
			  if (minutes < 0) clearInterval(interval);

			  if ((seconds <= 0) && (minutes <= 0)) {
			  	clearInterval(interval);
			  	$('#form-test').submit();

			  }

			  timer2 = minutes + ':' + seconds;
			}, 1000);

			// $('.start-test').css("display", "none");
		// });
	});