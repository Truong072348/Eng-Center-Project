@extends('admin.layout.index')
@section('style')
<link rel="stylesheet" type="text/css" href="css/account.css">
<!-- <link rel="stylesheet" href="https://code.jquery.com/ui/1.11.1/themes/smoothness/jquery-ui.css" /> -->
@endsection
@section('breadbrum')
<div class="breadcrumb">
	<ul class="clear-fix">
		<li><a><i class="fas fa-home"></i> Dashboard</a></li>
		<li>Accounts</li>
	</ul>
</div>
@endsection
@section('title')
<div class="page-title">
	<h1><img src="Images/folder.png">Accounts</h1>
</div>
@endsection
@section('content')
<div class="list-wr">
	<div class="tablelist listQa">
		<div class="title-wr">
			<h3>Danh sách tài khoản</h3>
		</div>
		<div class="fill" id="b_col">
			<form>
				<input type="hidden" name="_token" value="{{csrf_token()}}">
				<div class="fill-left">
					<input type= "text" class="searchFil" name="search" id="searchFill" placeholder="Search for name">
				</div>
			</form>
		</div>
		@if(isset($account))
		<div class="row_q">
			<span id="show_row">{{$account->count()}}</span> of 
			<select id="select-record">
				<option value="10">10</option>
				<option value="15">15</option>
			</select>
			<span>record per page</span>
		</div>
		<div class="qa-wr" id="result">
			
			<table id="mytable">
				<thead>
					<tr>
						<th class="stt">#</th>
						<th class="id">ID</th>
						<th class="user">User</th>
						<th class="type" id='type_header'>Type <img src="Images/sort.png"></th>
						<th class="mail">Email</th>
						<th class="tel" id='time_header'>Date Register <img src="Images/sort.png"></th>
						<th class="option">Action</th>
					</tr>
				</thead>
				<tbody id="table-q">
					@php($value = 0)
					@foreach($account as $key)
					<tr>
						
						<td></td>
						<td class="id">{{$key->id}}</td>
						<td class="avatar"><img src="{{$key->avatar}}">
						@if($key->id_utype == 2)
						<span class="name"><a href="admin/teacher/edit/{{$key->id}}">{{$key->t_name}}</a></span></td>
						<td class="type green">teacher</td>
						@elseif($key->id_utype == 3)
						<span class="name"><a href="admin/teacher/edit/{{$key->id}}">{{$key->st_name}}</a></span></td>
						<td class="type blue">student</td>
						@else 
						<span class="name">DLD.com</span></td>
						<td class="type red">admin</td>
						@endif
						<td class="mail">{{$key->email}}</td>
						<td class="tel">{{$key->created_at}}</td>
						<td>
							@if($key->id_utype > 1)
							<ul class="menu-dropdown">
							    <li class="taction">Action</li>
								<li class="dropdown-child">
									<ul>
										<li><a href="admin/teacher/edit/{{$key->id}}">Detail</a></li>
									</ul>
								</li>
							</ul>
							@endif
						</td>
						
					</tr>
					@endforeach
				</tbody>
			</table>
			<span class="row_q" id="show_entry">Showing {{$account->firstItem()}} to {{$account->lastItem()}} of {{$account->total()}} entries</span>
		</div>
		@endif
	</div>
	<div class="pagination-wr">
		{!!$account->links()!!}
	</div>
	<!-- <button id="myDelete">Xóa</button> -->
</div>
@endsection
@section('script')
<script src="js/ajaxPaginate.js"></script>
<script>
$(document).ready(function(){
  $("#searchFill").on("keyup", function() {
    var value = $(this).val().toLowerCase();
    $("#table-q tr").filter(function() {
      $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
    });
  });
});
$(document).on('click', '.menu-dropdown', function(){
		$(this).find('.dropdown-child').slideToggle();
	});

var table = $('#mytable');

	$('#type_header, #time_header')
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
</script>
<!-- <script src="https://code.jquery.com/ui/1.11.1/jquery-ui.min.js"></script>
<script src="https://code.jquery.com/jquery-migrate-3.0.0.min.js"></script> -->
<!-- <script type="text/javascript">
	$(document).ready(function(){
		$( "#form" ).dialog({
		autoOpen: false
		});
	$('#myDelete').on('click', function(){
	
		var deleteForm = $('<div id="form">Confirm delete?</div>');
		
		deleteForm.dialog({
		title: 'Error',
		close: function(event, ui)
		{
		$(this).dialog('close');
		}
		
	});
		});
	});
</script> -->
@endsection

<!-- <form class="">
	<label>Location</label>
	<div class="form-group">
		<input type="text" class="form-control" placeholder="Nha Trang">
	</div>
	<div class="checkbox">
		<label><input type="checkbox"> Ghi Nhớ</label>
	</div>
		<label>Date Pickup</label>
		<div class="form-group form-inline">
			<input type="email" class="form-control" placeholder="Email">
			<select class="form-control">
				<option>2</option>
			</select>
	</div>
	<label>Date Off</label>
	<div class="form-group form-inline">
		<input type="password" class="form-control" placeholder="Password">
		<select class="form-control">
			<option>2</option>
		</select>
	</div>
	<label>Car Type</label>
	<div class="form-group col-ms-6">
		<input type="text" class="form-control" placeholder="Nha Trang">
	</div>
</form> -->