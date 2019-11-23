$(document).ready(function(){
	$('#select-record').on('change', function(){
		$record = $(this).val();

		
		$.ajax({
			url: 'admin/account/list',
			type: 'get',
			data: {
				_record: $record
			}, 
			success: function(data) {
				var $table = $(data).find('#table-q'),
					$row = $(data).find('#show_entry'),
					$show = $(data).find('#show_row');
					$paginate = $(data).find('.pagination-wr');
		
				
			
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
});