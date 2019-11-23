@extends('admin.layout.index')
@section('style')
<link rel="stylesheet" type="text/css" href="css/account.css">
<link rel="stylesheet" type="text/css" href="css/course.css">
@endsection
@section('breadbrum')
<div class="breadcrumb">
	<ul class="clear-fix">
		<li><a><i class="fas fa-home"></i> Dashboard</a></li>
		<li>Tests</li>
	</ul>
</div>
@endsection
@section('title')
<div class="page-title">
	<h1><img src="Images/folder.png">Tests</h1>
</div>
@endsection
@section('search')
<div class="container-search">
	<div class="add">
		<a href="admin/test/add">+ Add Test</a>
	</div>
</div>
@endsection

@section('content')
<div class="list-wr">
	<div class="tablelist listQa">
		<div class="title-wr">
			<h3>Danh sách bài kiểm tra</h3>
		</div>
		<div class="fill-wr">
			<div class="fill-right">
				<form method="POST" action="{{Route('searchTest')}}">
					<input type="hidden" name="_token" value="{{csrf_token()}}">
					<input type= "text" class="searchFil" name="search" id="searchFill" placeholder="Search For Name">
				</form>
			</div>
		</div>
		
		<div class="row_q">
			<span id="show_row">{{$test->count()}}</span> of
			<select id="select-record">
				<option value="5">5</option>
				<option value="10">10</option>
				<option value="15">15</option>
			</select>
			<span>record per page</span>
		</div>
		<div class="qa-wr" id="result">
			<div class="table">
				<table id="mytable">
					<thead>
						<tr>
							<th class="c_t">Title</th>
							<th class="c_cate" id='cate_header'>Category <img src="Images/sort.png"></th>
							<th class="c_n_s" id='nques_header'>Number Of Question <img src="Images/sort.png"></th>
							<th class="c_n_t" id='time_header'>Limited Time <img src="Images/sort.png"></th>
							<!-- <th class="c_n_e">Number of Enrrolled User</th> -->
							<th class="c_action">Action</th>
						</tr>
					</thead>
					<tbody id="table-q">
						@php($i = 0)
						
						@foreach($test as $t)
						@foreach($detail as $d)
						@if($d->id_test == $t->id)
							@php($i = $i + 1)
						@endif
						@endforeach
						<tr>
							<td>{{$t->name}}</td>
							<td class="c_cate">
								@foreach($category as $cate)
								@if($cate->id == $t->id_category)
									{{$cate->name}}
								@endif
								@endforeach
								</br>
								<span class="idt">{{$t->id}}</span>

							</td>
							<td class="c_n_s">{{$i}}</td>
							<td class="c_n_t">{{$t->time}}</td>
							<td class="c_action">
								<ul class="menu-dropdown">
									<li class="taction">Action
									</li>
									<li class="dropdown-child">
										<ul>
											<li><a href="admin/test/edit/{{$t->id}}">Edit</a></li>
											<li><a href="admin/test/deletelist/{{$t->id}}">Delete</a></li>
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
			<span class="row_q" id="show_entry">Showing {{$test->firstItem()}} to {{$test->lastItem()}} of {{$test->total()}} entries</span>		</div>

	</div>
	<div class="pagination-wr">
		{!!$test->links()!!}
	</div>
	<div class="modal" id="ex7" >
		<p>Bài kiểm tra đã kích hoạt. Không thể xóa !!!</p>
	</div>
	<div class="modal" id="ex8" >
		<p>Xóa bài kiểm tra thành công</p>
	</div>
</div>
@endsection
@section('script')
@if(session('deleteTestFail'))
<script>
	$('#ex7').modal('open');
</script>
@endif
@if(session('deleteTestSuccess'))
<script>
	$('#ex8').modal('open');
</script>
@endif
<script src="js/test.js"></script>
@endsection