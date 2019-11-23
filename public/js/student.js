$(document).ready(function(){
	$(document).on('click', '.menu-dropdown', function(){
		$(this).find('.dropdown-child').slideToggle();
	});
	$('#select-record').on('change', function(){
		$record = $(this).val();

		
		$.ajax({
			url: 'admin/student/list',
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
	var table = $('#mytable');

	$('#enrol_header, #time_header')
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
});