@extends('admin.layout.index')
@section('style')
<link rel="stylesheet" type="text/css" href="css/account.css">
<link rel="stylesheet" type="text/css" href="css/course.css">
<link rel="stylesheet" type="text/css" href="css/comment.css">
@endsection
@section('breadbrum')
<div class="breadcrumb">
	<ul class="clear-fix">
		<li><a><i class="fas fa-home"></i> Dashboard</a></li>
		<li>Courses</li>
	</ul>
</div>
@endsection
@section('title')
<div class="page-title">
	<h1><img src="Images/folder.png">Courses</h1>
</div>
@endsection
@section('search')
<div class="container-search">
	<div class="add">
		<a href="admin/course/add">+ Add Course</a>
	</div>
</div>
@endsection
@section('content')
<div class="list-wr">
	<div class="tablelist listQa">
		<div class="title-wr">
			<h3>Danh sách khóa học</h3>
		</div>
		<div class="fill-wr">
			<div class="fill-right">
				<form method="POST" action="{{Route('searchCourse')}}">
					<input type="hidden" name="_token" value="{{csrf_token()}}">
					
					<input type= "text" class="searchFil" name="search" id="searchFill" placeholder="Search For Name">
				</form>
			</div>
		</div>
		
		@if(isset($course))
		<div class="row_q">
			<span id="show_row">{{$course->count()}}</span> of
			<select id="select-record">
				<option value="5">5</option>
				<option value="10">10</option>
				<option value="15">15</option>
			</select>
			<span>record per page</span>
			<div class="type_c">
				<ul class="menu-dropdown" id="select-type">
					<li>Select Type</li>
					<li class="dropdown-child">
						<ul>
							@if(!empty($categories))
							@foreach($categories as $cate)
							<li><a href="admin/course/list/{{$cate->id}}">{{$cate->name}}</a></li>
							@endforeach
							@endif
						</ul>
					</li>
				</ul>
			</div>
		</div>
		<div class="qa-wr" id="result">
			<div class="table">
				<table id="mytable">
					<thead>
						<tr>
							<th class="c_t">Title</th>
							<th class="c_cate" id='cate_header'>Category <img src="Images/sort.png"></th>
							<th class="c_n_s" id='nsection_header'>Number Of Section <img src="Images/sort.png"></th>
							<th class="c_n_t" id='ntest_header'>Number Of Test <img src="Images/sort.png"></th>
							<th class="c_n_e" id='nenrol_header'>Number of Enrrolled User <img src="Images/sort.png"></th>
							<th class="c_action">Action</th>
						</tr>
					</thead>
					<tbody id="table-q">

						@foreach($course as $key=>$crs)
						<tr>
							<td class="">{{$crs->name}}</td>
							<td class="c_cate">
								@if(isset($categories, $types))
								@foreach($types as $t)
								@if($crs->id_ctype == $t->id)
								
								{{$t->level}}
								
								@foreach($categories as $c)
								@if($t->id_category == $c->id)
								
								 {{$c->name}}
								@endif
								@endforeach

								@endif
								@endforeach
								 
								
								@endif
							</td>
							<td class="c_n_s">
								@if(isset($lessons))
								@php($count_lesson = 0)
								@foreach($lessons as $l)
								@if($l->id_course == $crs->id)
								@php($count_lesson = $count_lesson + 1)
								@endif
								@endforeach
								{{$count_lesson}}
								@endif
							</td>
							<td class="c_n_t">
								@if(isset($tests))
								@php($count_test = 0)
								@foreach($tests as $t)
								@if($t->id_course == $crs->id)
								@php($count_test = $count_test + 1)
								@endif
								@endforeach
								{{$count_test}}
								@endif
							</td>
							<td class="c_n_e">
								@if(isset($registers))
								@php($count_re = 0)
								@foreach($registers as $r)
								@if($r->id_course == $crs->id)
								@php($count_re = $count_re + 1)
								@endif
								@endforeach
								{{$count_re}}
								@endif
							</td>
							<td class="c_action">
								<ul class="menu-dropdown">
									<li class="taction">Action
									</li>
									<li class="dropdown-child">
										<ul>
											<li><a href="admin/course/comment/{{$crs->id}}">Comment</a></li>
											<li><a href="admin/course/edit/{{$crs->id}}">Update</a></li>
										</ul>
									</li>
								</ul>
							</td>
						</tr>
						@endforeach
					</tbody>
				</table>
			</div>
			<span class="row_q" id="show_entry">Showing {{$course->firstItem()}} to {{$course->lastItem()}} of {{$course->total()}} entries</span>
		</div>
		@endif
	</div>
	<div class="pagination-wr">
		{!!$course->links()!!}
	</div>
</div>
@endsection
@section('script')
<script src="js/course.js"></script>
@endsection