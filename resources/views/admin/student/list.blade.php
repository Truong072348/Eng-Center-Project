@extends('admin.layout.index')
@section('style')
<link rel="stylesheet" type="text/css" href="css/account.css">
<link rel="stylesheet" type="text/css" href="css/student.css">
@endsection
@section('breadbrum')
<div class="breadcrumb">
	<ul class="clear-fix">
		<li><a><i class="fas fa-home"></i> Dashboard</a></li>
		<li>Students</li>
	</ul>
</div>
@endsection
@section('title')
<div class="page-title">
	<h1><img src="Images/folder.png">Students</h1>
</div>
@endsection
@section('search')
<div class="container-search">
	<div class="add">
		<a href="admin/student/add">+ Add Student</a>
	</div>
</div>
@endsection
@section('content')
<div class="list-wr">
	<div class="tablelist listQa">
		<div class="title-wr">
			<h3>Danh sách học viên</h3>
		</div>
		<div class="fill-wr fill-wr-right">
			<div class="fill-right">
				<form method="POST" action="{{Route('searchStudent')}}">
					<input type="hidden" name="_token" value="{{csrf_token()}}">
					<input type= "text" class="searchFil" name="search" id="searchFill" placeholder="Search for name">
				</form>
			</div>
		</div>
		@if(isset($student))
		<div class="row_q">
			<span id="show_row">{{$student->count()}}</span> of
			<select id="select-record">
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
							<th class="av">Photo</th>
							<th class="n">Name</th>
							<th class="mail">Email</th>
							<th class="dateadd" id='time_header'>Date Added <img src="Images/sort.png"></th>
							<th class="enrol" id='enrol_header'>Enrrol Courses <img src="Images/sort.png"></th>
							<th class="action">Action</th>
						</tr>
					</thead>
					<tbody id="table-q">

						@if(!empty($account) && !empty($student))
						@foreach($student as $st)
						@foreach($account as $acc)
						@if($st->id == $acc->id)
						<tr>
						
							<td class="av"><img src="{{$acc->avatar}}"></td>
							<td>{{$acc->name}}</td>
							
							<td class="mail">{{$acc->email}}</td>
							<td class="dateadd">
								{{$acc->created_at}}
							</td>
							<td class="enrol">
								<ul>
									@if(!empty($registers))
									@foreach($registers as $register)
										@if($register->id_student == $acc->id)
										@foreach($course as $c)
											@if($c->id == $register->id_course)
												{{$c->name}}
											@endif
										@endforeach
										@endif
									@endforeach
									@endif
								</ul>
							</td>
							<td>
								<ul class="menu-dropdown">
									<li class="taction">Action</li>
									<li class="dropdown-child">
										<ul>
											<li><a href="admin/student/profile/{{$acc->id}}">Chi tiết</a></li>
										</ul>
									</li>
								</ul>
							</td>
						</tr>
						@endif
						@endforeach
						@endforeach
						@endif
					</tbody>
				</table>
			</div>
			<span class="row_q" id="show_entry">Showing {{$student->firstItem()}} to {{$student->lastItem()}} of {{$student->total()}} entries</span>
		</div>
		@endif
	</div>
	<div class="pagination-wr">
		{!!$student->links()!!}
	</div>
</div>
@endsection
@section('script')
<script src="js/student.js"></script>
@endsection