$(document).ready(function(){

	var $idcourse = $('input[name=idcourse]').val();

	$('#select-record').on('change', function(){
		$record = $(this).val();

		$.ajax({
			url: 'admin/course/test/' + $idcourse,
			type: 'get',
			data: {
				_record: $record
			}, 
			success: function(data) {
				var $table = $(data).find('#table-q-2'),
					$row = $(data).find('#show_entry-2'),
					$show = $(data).find('#show_row-2');
					$paginate = $(data).find('.pagination-wr-2');
					

				$('#table-q-2').remove();
				$('#show_entry-2').remove();
				$('.pagination-wr-2').remove();

				$('#mytable-2').append($table);
				$('#result-2').append($row);
				$('#show_row-2').html($show.text());
				$('.list-wr-2').append($paginate);
			}
		});
	});

	$(document).on('click', '.menu-dropdown', function(){
		$(this).find('.dropdown-child').slideToggle();
	});

	var $inputTest = $('input[name=test]'),
		$inputId = $('input[name=idtest]');
		$inputTest.val(sessionStorage.getItem('testid'));

	var $name = $('input[name=name]').val();


	$('input[name=name]').on('change', function(){
		$name = $(this).val();
		sessionStorage.setItem('name', $name);
	});

	if(sessionStorage.getItem('name') != null){
		$('input[name=name]').val(sessionStorage.getItem('name'));
	}

	if(sessionStorage.getItem('testid') != null){
		$('input[name=idtest]').val(sessionStorage.getItem('testid'));
	}



	$(document).on('click', '.SeleteTo', function(){
		var $testID = $(this).closest('tr').find('.c_cate').children('.idt').text();
		sessionStorage.setItem('testid', $testID);
		$inputTest.val(sessionStorage.getItem('testid'));

		$('input[name=idtest]').val(sessionStorage.getItem('testid'));	
	});

});