
$(document).ready( function(){

	$('#type').on('change', function(event){
		var typeQ = $(this).val();
		$.ajax({
			// url: 'admin/question/list' + typeQ,
			url: 'admin/question/list',
			type: 'get',
			data: {
				// // "_token": "{{ csrf_token() }}",
				id: typeQ
			},
			
			success: function(data){
				// (console.log("3: " + data);)
				var $result = $(data).find('#result');
				// console.log($result);
				$('.qa-wr').empty().append($result);
				
			},
			error: function(e){
				$('.form-type').html('<p>Load Error!!!<p>');
					console.log(e.message);
				}
			});
	});

});

