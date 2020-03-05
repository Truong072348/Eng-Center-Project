$(document).ready(function(){
	var listQs = $('input[name=basicCount]').val();
	var listPara = $('input[name=paraCount]').val();
	var listAudio = $('input[name=paraAudio]').val();
	var $arrAnswer = [];
	$(document).on("change", "input[type='radio']", function(){
		$answer = $(this).val();
		$idq = $(this).closest('.group-answer').next().val();
		var exsist = false;
		for(var i in $arrAnswer){
			if($arrAnswer[i].id == $idq){
				$arrAnswer[i].answer = $answer;
				exsist = true
				break;
			}
		}
		if(exsist == false) {
			$arrAnswer.push({answer: $answer, id: $idq});
		}

	});

	$(document).on('click','.nextQuestion', function(){
	var $type = $('input[name=type]').val();
	var $id = $('input[name=idtest]').val();
	var $time = $('input[name=time]').val();
	var $token = $('input[name=_token]').val();
	
		$.ajax({
		url: 'test/' + $id,
		type: 'get',
		data: {
			_type: $type
		},
		
		success: function(data){
			var $content = $(data).find('.qs-wr').html();
			$('.qs-wr').empty().html($content);
		},
		error: function(e){
			$('.form-type').html('<p>Load Error!!!<p>');
				console.log(e.message);
			}
		});
			
		$.ajax({
			url: 'postQuiz/' + $id,
			type: 'post',
			data: {
				"_token": $token,
				_arrAnswer: $arrAnswer,
				_time: $time, 
				_type: $type
			},
			

			success: function(data){
			}
		});
	});

	var timer2 = $('#time').text();
	var interval = setInterval(function() {
	var timer = timer2.split(':');
	var minutes = parseInt(timer[0], 10);
	var seconds = parseInt(timer[1], 10);
	--seconds;
	minutes = (seconds < 0) ? --minutes : minutes;
	seconds = (seconds < 0) ? 59 : seconds;
	seconds = (seconds < 10) ? '0' + seconds : seconds;
	
	$('.time-test span').html(minutes + ':' + seconds);
	$('input[name=time]').val('00:' + minutes +':'+ seconds);
	if (minutes < 0) clearInterval(interval);
	if ((seconds <= 0) && (minutes <= 0)) {
		clearInterval(interval);
		$('#form-test').submit();
	}
	timer2 = minutes + ':' + seconds;
	}, 1000);
	if(listQs > 0) {
		$('.list-q ul').append('<span class="typeQuestion">Basic Question</span>')
	}
	for(var i = 0; i<listQs; i++){
		var number;
		if (i < 10) {
			number = '<li><a href="#">0'+(i + 1)+'</a></li>';
		}
		else {
			number = '<li><a href="#">'+(i+ 1)+'</a></li>';
		}
		$('.list-q ul').append(number);
	};
	if(listPara > 0){
		$('.list-q ul').append('<span class="typeQuestion">Paragraph Question</span>')
	}
	for(var i = 0; i<listPara; i++){
		var number;
		if (i < 10) {
			number = '<li><a href="#">0'+(i + 1)+'</a></li>';
		}
		else {
			number = '<li><a href="#">'+(i + 1)+'</a></li>';
		}
		$('.list-q ul').append(number);
	}
	if(listAudio > 0){
		$('.list-q ul').append('<span class="typeQuestion">Audio Question</span>')
	}
	for(var i = 0; i<listAudio; i++){
		var number;
		if (i < 10) {
			number = '<li><a href="#">0'+(i + 1)+'</a></li>';
		}
		else {
			number = '<li><a href="#">'+(i + 1)+'</a></li>';
		}
		$('.list-q ul').append(number);
	}
});

