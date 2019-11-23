$(document).ready( function(){

	var arrayID = [];
	var testWr = $('.wr-test-content').html();
	if(testWr !== null){
		sessionStorage.setItem('testWr', testWr);
	}
	var $list = $('.question-wr');
	$('input[name=list]').val($list.length);

	/*validate input category to level*/
	$('#select-record').on('change', function(){
		$record = $(this).val();
		
		$.ajax({
			url: 'admin/test/list',
			type: 'get',
			data: {
				_record: $record
			}, 
			success: function(data) {
				var $table = $(data).find('#table-q'),
					$row = $(data).find('#show_entry'),
					$show = $(data).find('#show_row');
					$paginate = $(data).find('.pagination-wr');
					$('.list-wr').append($paginate);

					$('#table-q').remove();
					$('#show_entry').remove();
					$('.pagination-wr').remove();

					$('#mytable').append($table);
					$('#result').append($row);
					$('#show_row').html($show.text());
					$('.list-wr').append($paginate);

			}
		});

	});

	$('#type').on('change', function(event){
		var typeQ = $(this).val();
		var idT = $('input[name=idtest]').val();
		$.ajax({
			url: 'admin/test/edit/' + idT,
			type: 'get',
			data: {
				// // "_token": "{{ csrf_token() }}",
				idQ: typeQ
			},
			success: function(data){

				var $result = $(data).find('#result');
				$('.qa-wr').empty().append($result);
				
				$('.question-wr').each(function(){
					var $id = $(this).find('.idq').html();
					arrayID.push($id);
				});

				if(typeQ == 3){
					$('.table-q tr').each(function(){
				
						var $content = $(this).find('.id_question').html();

						if( $.inArray($content, arrayID) != -1){
							$(this).find('.SelectTo').empty();
						}
					});
				} else {
					$('.table-q').each(function(){
				
						var $content = $(this).find('.id_question').html();

						if( $.inArray($content, arrayID) != -1){
							$(this).find('.SelectTo').empty();
						}
					});
				}
				
			},
			error: function(e){
				$('.form-type').html('<p>Load Error!!!<p>');
			}
		});

		sessionStorage.setItem('type', typeQ);
	});
	/*session storage input name, time, content of test when load page*/
	var $name = $('input[name=name]').val(),
	    $time = $('input[name=time]').val();
	    
	if($name != ''){
		sessionStorage.setItem('name', $name);
	}

	if($time != ''){
		sessionStorage.setItem('time', $time);
	}

	$('input[name=name]').on('change', function(){
		$name = $(this).val();
		sessionStorage.setItem('name', $name);
	});
	$('input[name=time]').on('change', function(){
		$time = $(this).val();
		sessionStorage.setItem('time', $time);
	});

	if(sessionStorage.getItem('name') != null){
		$('input[name=name]').val(sessionStorage.getItem('name'));
	}

	if(sessionStorage.getItem('time') != null){
		$('input[name=time]').val(sessionStorage.getItem('time'));
	}

	// if(sessionStorage.getItem('testWr') != null){
	// 	$('.wr-test-content').empty().append(sessionStorage.getItem('testWr'));
	// }

	/*event click delete all clear session storage item in test content*/
	$('.deleteAll').on('click', function(){
		sessionStorage.removeItem('testWr');
		$('.wr-test-content').empty();
	});


	/*event click select to question page*/

	$(document).on('click','.SelectTo', function(event){
		var $list = $('.question-wr'),
			$nextQuestion = $list.length + 1,
			$typeQuestion = sessionStorage.getItem('type'),
			$content;
			
			$(this).empty();
		$('input[name=list]').val($list.length);

		/*type = paragraph and audio*/
		if($typeQuestion == 1 || $typeQuestion == 2){


			$content =  $typeQuestion == 1 ? $(this).parent().parent().children('.content').text() : $(this).parent().parent().children('.content').html();
			$idquestion = $(this).parent().parent().children('.paraType').children().text();
			$listquestion = $(this).closest('.table-content').next().find('.question');
			$listanswer = $(this).closest('.table-content').next().find('.answer');
			
			var qArr = [],
				qAns = [];

			$.each($listquestion, function(){
				qArr.push('<div class="q-qestion"><p class="question">Question: <span>'+$(this).eq(0).text()+'</span></p>');
			});
			$.each($listanswer, function(){
				qAns.push('<p class="answer"><span>Correct Answer: </span>'+$(this).eq(0).text()+'</p></div>');
			});
			var arrayCombined = $.map(qArr, function(v, i) {
				return [v, qAns[i]];
			});
			var questionArr = $.map(arrayCombined, function(val,index) {
				var str = val;
				return str;
			}).join('');

			var $questionWr = '<div class="question-wr">'+
									'<span class="title">Question '+$nextQuestion+' </span> (id <span class="idq">'+$idquestion+'</span>)<a class="delete" style="float: right">x</a>'+
									'<div class="q-content">'+$content+
										'<input type="hidden" class="inputID" name="question[]" value="'+$idquestion+'">'+
									'</div>'+
									questionArr +
								'</div>';

			$('.wr-test-content').append($questionWr);

		} else if($typeQuestion == 3)  {
			
			$question = $(this).closest('tr').find('.bqes').text();
			$answer = $(this).closest('tr').find('.asw').text();
			$idquestion = $(this).closest('tr').find('.stt').text();

			var $questionWr = '<div class="question-wr">'+
				'<span class="title">Question '+$nextQuestion+' </span>(id <span class="idq">'+$idquestion+'</span>)'+$question+'<a class="delete" style="float: right">x</a>'+
				'<p class="answer">'+
					'<span>Correct Answer </span>'+$answer+
				'</p>'+
				'<input type="hidden" name="question[]" value="'+$idquestion+'">'
			    '</div>';

			$('.wr-test-content').append($questionWr);
		} else {
			alert('Vui lòng chọn loại câu hỏi');
		}

		/*save content test in session storage*/
		testWr = $('.wr-test-content').html();
		if(testWr !== null) {
			sessionStorage.setItem('testWr', testWr);
		}
	});


	$(document).on('click', '.delete', function(){
		var $show = $(this).closest('.question-wr').find('.idq').text();
		if(sessionStorage.getItem('type') == 3){
			$('.table-q tr').each(function(){
				var $content = $(this).find('.id_question').html();
				if($content == $show ){
					$(this).find('.SelectTo').append('Select');
				}
			});
		}
		else {
			$('.table-q').each(function(){
				var $content = $(this).find('.id_question').html();
				if($content == $show ){
					$(this).find('.SelectTo').append('Select');
				}
			});
		}

		$(this).closest('.question-wr').remove();
		var $list = $('.question-wr');
		$('input[name=list]').val($list.length);
		
		$('.question-wr').each(function(index){
			$(this).closest('.question-wr').find('.title').html('Question '+(index + 1));
		});

		var $inputID = $('.inputID');
		var $listInputID = $inputID.length;
		$('.inputID').each(function(index){
			// $(this).attr("name", "q"+(index + 1)+"");
			$(this).attr("name", "question[]");
		});

		testWr = $('.wr-test-content').html();
		sessionStorage.setItem('testWr', testWr);
	});

	$(document).on('click', '#confirm',function(){
		var $name = $('input[name=name]').val(),
			$time = $('input[name=time]').val(),
			$cate = $('#category').val(),
			$testWr = sessionStorage.getItem('testWr');
		
		if($name != '' && $time != '' && $cate != '' && $testWr != null){
			sessionStorage.clear();
		}


	});


	var arrayID = [];
	$('.question-wr').each(function(){
		var $id = $(this).find('.idq').html();
		arrayID.push($id);
	});


	$('.table-q').each(function(){
		var $content = $(this).find('.id_question').html();
		if( $.inArray($content, arrayID) != -1){
			$(this).find('.SelectTo').empty();
		}
	});

	var table = $('#mytable');

	$('#nques_header, #cate_header, #time_header')
	    .wrapInner('<span title="sort this column"/>')
	    .each(function(){
	        
	        var th = $(this),
	            thIndex = th.index(),
	            inverse = false;
	        
	        th.click(function(){
	            
	            $('#mytable').find('td').filter(function(){
	                
	                return $(this).index() === thIndex;
	                
	            }).sortElements(function(a, b){
	                
	                return $.text([a]) > $.text([b]) ?
	                    inverse ? -1 : 1
	                    : inverse ? 1 : -1;
	                
	            }, function(){
	                
	                // parentNode is the element we want to move
	                return this.parentNode; 
	                
	            });
	            
	            inverse = !inverse;
	                
	        });
	            
	    });

	$(document).on('click', '.menu-dropdown', function(){
		$(this).find('.dropdown-child').slideToggle();
	});
});

$(window).on('load', function(){
	var testWr = $('.wr-test-content').html();
	if(testWr !== null) {
		sessionStorage.setItem('testWr', testWr);
	}

	var arrayID = [];
	$('.question-wr').each(function(){
		var $id = $(this).find('.idq').html();
		arrayID.push($id);
	});


	$('.table-q').each(function(){
		var $content = $(this).find('.id_question').html();
		if( $.inArray($content, arrayID) != -1){
			$(this).find('.SelectTo').empty();
		}
	});
	
});