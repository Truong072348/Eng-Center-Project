$(document).ready(function(){

	if($('#type').val() == 1){
		CKEDITOR.env.isCompatible = true;
		CKEDITOR.replace('editor1');
	}


	$('#addQ').on("click", function(){
		var listQ = $('.qa-group');
		var legend = listQ.length;
		if(legend < 4){
			var index = legend + 1;
			var ansr = ['as1_','as2_','as3_','as4_']
			$('.qa-wr').append('<div class="qa-group"><h3>Question '+(index)+'</h3><div class="form-group"><input type="text" name="ques'+(index)+'" placeholder="Question"></div><div class="qa-group-wr"><div class="qa-g-left"><div class="form-group"><input type="text" name="cransewr'+(index)+'" placeholder="Correct Answer"></div><div class="form-group"><input type="text" name="'+(ansr[legend]+1)+'" placeholder="Answer"></div></div><div class="qa-g-right"><div class="form-group"><input type="text" name="'+(ansr[legend]+2)+'" placeholder="Answer"></div><div class="form-group"><input type="text" name="'+(ansr[legend]+3)+'" placeholder="Answer"></div></div></div>');
		} else {
			alert('Không thể thêm câu hỏi');
		}
	})


	$(document).on('change', '#type', function(){
		var typeQ = $(this).val();
		// sessionStorage.setItem("typeid", typeQ);
		// var q = sessionStorage.getItem("typeid");
		// console.log(q);
		var audio = '<input type="file" accept="audio/*" name="audio" required>';
		if(typeQ == 1){
			$('div.contentQ').empty().append('<textarea name="content" class="form-control " id="editor1"></textarea>');
			CKEDITOR.env.isCompatible = true;
			CKEDITOR.replace('editor1');
		}
		if(typeQ == 2){
			$('div.contentQ').empty().append(audio);
		}

		if(typeQ == 3){
			$('div.contentQ').empty();
		}

	});

	$(document).on('click', '.deleteQ', function(){
		$(this).closest('.qa-group').remove();
		$('.title').each(function(index){
			$(this).html('Question '+(index + 1));
		});
	});

	sessionStorage.getItem("typeid");

});