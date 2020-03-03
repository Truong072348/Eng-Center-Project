@extends('admin.layout.index')
@section('style')
<link rel="stylesheet" type="text/css" href="css/course.css">
@endsection

@section('breadbrum')
<div class="breadcrumb">
	<ul class="clear-fix">
		<li><a><i class="fas fa-home"></i> Dashboard</a></li>
		<li><a href="admin/course/list">Courses</a></li>
		<li><a href="admin/course/edit/{{$course->id}}">{{$course->name}}</a></li>
		<li>add Test</li>
	</ul>
</div>
@endsection
@section('title')
<div class="page-title">
	<h1><img src="Images/folder.png">Tests</h1>
</div>
@endsection
@section('content')
<fieldset>
	@if(session('notify'))
	<div class="alert alert-success">
		{{session('notify')}}
	</div>
	@endif
	@if(session('error'))
	<div class="alert alert-success">
		{{session('error')}}
	</div>
	@endif
	<form method="POST" method="admin/course/test/{{$course->id}}" class="form-submit">
		<input type="hidden" name="_token" value="{{csrf_token()}}">
		<input type="hidden" name="idcourse" value="{{$course->id}}">
		<div class="form-left">
			<div class="form-group">
				<input type="text" name="name" placeholder="Title" value="{{old('name')}}">
				@if($errors->has('name'))
				<div class="notify-error">
					{{$errors->first('name')}}
				</div>
				@endif
			</div>
		</div>
		<div class="form-right">
			<div class="form-group">
				<input name="test" disabled>
				@if($errors->has('idtest'))
				<div class="notify-error">
					{{$errors->first('idtest')}}
				</div>
				@endif
				<input type="hidden" name="idtest">
			</div>
		</div>
		<div class="btn-group">
			<button type="submit">Confirm</button>
		</div>
	</form>
</fieldset>
<div class="list-wr list-wr-2">
	<div class="tablelist listQa">
		<div class="title-wr">
			<h3>List of test</h3>
		</div>
		<div class="fill-wr">
			<div class="fill-right">
				<form method="POST" action="{{Route('searchTestLesson')}}">
					<input type="hidden" name="_token" value="{{csrf_token()}}">
					<input type="hidden" name="id_course" value="{{$course->id}}">
					<input type= "text" class="searchFil" name="search" placeholder="Search For Name">
				</form>
			</div>
		</div>
		
		<div class="row_q">
			<span id="show_row-2">{{$testList->count()}}</span> of
			<select id="select-record">
				<option value="5">5</option>
				<option value="10">10</option>
				<option value="15">15</option>
			</select>
			<span>record per page</span>
		</div>
		<div class="qa-wr" id="result-2">
			<div class="table">
				<table id="mytable-2">
					<thead>
						<tr>
							<th class="c_t">Title</th>
							<th class="c_cate" id='id_header'>ID</th>
							<th class="c_n_s" id='number_header'>Number Of Question <img src="Images/sort.png"></th>
							<th class="c_n_t" id='time_header'>Limited Time <img src="Images/sort.png"></th>
							<!-- <th class="c_n_e">Number of Enrrolled User</th> -->
							<th class="c_action">Action</th>
						</tr>
					</thead>
					<tbody id="table-q-2">
						@php($i = 0)
						
						@foreach($testList as $t)
						@foreach($detail as $d)
						@if($d->id_test == $t->id)
							@php($i = $i + 1)
						@endif
						@endforeach
						<tr>
							<td>{{$t->name}}</td>
							<td class="c_cate">
								@foreach($categories as $cate)
								@if($cate->id == $t->id_category)
									{{$cate->name}}
								@endif
								@endforeach
								</br>
								<span class="idt">{{$t->id}}</span>
							</td>
							
							<td>{{$i}}</td>
							<td>{{$t->time}}</td>
							<td class="c_action">
								<ul class="menu-dropdown">
									<li class="taction">Action
									</li>
									<li class="dropdown-child">
										<ul>
											<li><a class="SeleteTo">Select</a></li>
											<li><a href="admin/test/edit/{{$t->id}}">Detail</a></li>
										</ul>
									</li>
								</ul>
							</td>
						</tr>
						@php($i = 0)
						@endforeach
					</tbody>
				</table>
			</div>
			<span class="row_q" id="show_entry-2">Showing {{$testList->firstItem()}} to {{$testList->lastItem()}} of {{$testList->total()}} entries</span>		
		</div>
	</div>
	<div class="pagination-wr pagination-wr-2">
		{!!$testList->links()!!}
	</div>
</div>
<div class="list-wr">
	<div class="tablelist listQa">
		<div class="title-wr">
			<h3>List of course test</h3>
		</div>
		@if(isset($test))
		<div class="fill-wr">
			<span class="row_q">{{$test->count()}} of 10 record per page</span>
			<div class="fill-right">
				<input type= "text" class="searchFil" id="searchFill" placeholder="Search For Test">
			</div>
		</div>
		<div class="qa-wr" id="result">
			<div class="table">
				<table>
					<thead>
						<tr>
							<th>Title</th>
				
							<th>ID</th>
							<th class="c_action">Actions</th>
						</tr>
					</thead>
					<tbody id="table-q">
						@foreach($test as $t)
						<tr>
							<td>{{$t->name}}</td>
						
							<td>{{$t->id_test}}</td>
							<td>
								<ul class="menu-dropdown">
									<li class="taction">Action
									</li>
									<li class="dropdown-child">
										<ul>
											<li><a href="admin/test/edit/{{$t->id_test}}">Detail</a></li>
											<li><a href="admin/test/delete/{{$t->id}}">Delete</a></li>
										</ul>
									</li>
								</ul>
							</td>
						</tr>
						@endforeach
					</tbody>
				</table>
			</div>
			<span class="row_q">Showing {{$test->firstItem()}} to {{$test->lastItem()}} of {{$test->total()}} entries</span>
		</div>
		@endif
	</div>
	<div class="pagination-wr">
		{!!$test->links()!!}
	</div>
	<div class="modal" id="ex6" >
		<p>Bài kiểm tra đã kích hoạt. Không thể xóa !!!</p>
	</div>
</div>
@endsection
@section('script')
<script src="js/add-course-test.js"></script>
<script src="js/sort-table.js"></script>
@if(session('deleteLessonTestFail'))
<script>
	$('#ex6').modal('open');
</script>
@endif
<script type="text/javascript">
	$(document).ready(function(){
	 
	 $("#searchFill").on("keyup", function() {
	   var value = $(this).val().toLowerCase();
	    $("#table-q tr").filter(function() {
	      $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
	    });
	  });


	var table = $('#mytable-2');

	$('#time_header, #number_header, #id_header')
	    .wrapInner('<span title="sort this column"/>')
	    .each(function(){
	        
	        var th = $(this),
	            thIndex = th.index(),
	            inverse = false;
	        
	        th.click(function(){
	            
	            $('#mytable-2').find('td').filter(function(){
	                
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
	})
 
</script>
@endsection