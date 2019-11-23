$(document).ready(function(){
 	
	$('.select-name').on("click", function(){
		$name = $(this).parent().parent().children('.n').text();
		$id = $(this).parent().parent().children('.code').text();
		$text = $name +' - '+ $id;
		$('#teacher').val($text);
		$('#idteacher').val($id);
	});

	$('#category').on('change', function(event){
	// event.preventDefault();
	var category = $(this).val();
	var token = $("input[name='_token']").val();
	$.ajax({

		url: 'admin/ajax/level',
		type: 'post',
		data: {
			_token: token,
			id: category
		},
		
		success: function(data){

			$('#level').html('');
			$.each(data, function(key, value){

				$('#level').append(
					'<option value="'+value.id+'">'+value.level+'</option>'
				);
			});
			
			}
		});
	});

	$('#select-record').on('change', function(){
		$record = $(this).val();
		
		$.ajax({
			url: 'admin/course/list',
			type: 'get',
			data: {
				_record: $record
			}, 
			success: function(data) {
				var $table = $(data).find('#table-q'),
					$row = $(data).find('#show_entry'),
					$show = $(data).find('#show_row');
					$paginate = $(data).find('.pagination-wr');
					
					console.log($table);

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


	$(document).on('click', '.menu-dropdown', function(){
		$(this).find('.dropdown-child').slideToggle();
	});
	
	/*preview img*/
	var reader = new FileReader();
	reader.onload = function(e){
		$('#preview').attr('src', e.target.result);
	}

	function readURL(input){
		if(input.files && input.files[0]){
			reader.readAsDataURL(input.files[0]);
		}
	} 

	$('#imgInput').on('change', function(){
		readURL(this);
	});

	var table = $('#mytable');

	$('#ntest_header, #nenrol_header, #nsection_header, #cate_header, #degree_header, #work_header, #course_header')
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