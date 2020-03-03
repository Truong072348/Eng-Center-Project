$(document).ready(function(){
	var listQs = $('input[name=basicCount]').val();
	var listPara = $('input[name=paraCount]').val();
	var listAudio = $('input[name=paraAudio]').val();
	

	$(document).on('click','.nextQuestion', function(){
		var $type = $('input[name=type]').val();
		var $id = $('input[name=idtest]').val();
			$.ajax({
				url: 'review/' + $id,
				type: 'get',
				data: {
					_type: $type,
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
	});

	if(listQs > 0) {
		$('.list-q ul').append('<span class="typeQuestion">Basic Question</span>');
	}

	for(var i = 0; i<listQs; i++){
		var number;
		if (i < 10) {
			number = '<li><a>0'+(i + 1)+'</a></li>';
		}
		else {
			number = '<li><a >'+(i+ 1)+'</a></li>';
		}
		$('.list-q ul').append(number);
	};


	if(listPara > 0){
		$('.list-q ul').append('<span class="typeQuestion">Paragraph Question</span>');
	}

	var $listPara = $('input[name=paraCount]');

	for(var i = 0; i<listPara; i++){

		var number;
		if (i < 10) {
			number = '<li><a >0'+(i + 1)+'</a></li>';
		}
		else {
			number = '<li><a >'+(i + 1)+'</a></li>';
		}
		$('.list-q ul').append(number);
	};

	if(listAudio > 0){
		$('.list-q ul').append('<span class="typeQuestion">Audio Question</span>');
	}


	for(var i = 0; i<listAudio; i++){
			var number;
			if (i < 10) {
				number = '<li><a>0'+(i + 1)+'</a></li>';
			}
			else {
				number = '<li><a>'+(i + 1)+'</a></li>';
			}
			$('.list-q ul').append(number);
		}
});