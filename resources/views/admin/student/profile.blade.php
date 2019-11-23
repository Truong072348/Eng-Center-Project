@extends('admin.layout.index')
@section('style')
<link rel="stylesheet" type="text/css" href="css/teacher.css">
<link rel="stylesheet" type="text/css" href="css/student.css">
@endsection
@section('breadbrum')
<div class="breadcrumb">
	<ul class="clear-fix">
		<li><a><i class="fas fa-home"></i> Dashboard</a></li>
		<li><a href="admin/student/list">Students</a></li>
		<li>Profile Student</li>
	</ul>
</div>
@endsection
@section('title')
<div class="page-title">
	<h1><img src="Images/folder.png">Student</h1>
</div>
@endsection
@section('content')
@section('content')
<fieldset>
	<legend>Thông tin học viên</legend>
	@if(session('errorpass'))
	<div class="alert alert-error">
		{{session('errorpass')}}
	</div>
	@endif
	@if(session('notify'))
	<div class="alert alert-success">
		{{session('notify')}}
	</div>
	@endif

	<div class="profile-wr">
		@if(isset($student))
		<div class="profile-wr-left">
			<div class="profile-img">
				<img src="Images/{{$student->avatar}}">
			</div>
			<div class="profile-intro">
				@if(isset($user))
				<p>ID User {{$user->id}}</p>
				<p>{{$user->username}}</p>
				<p>Số dư {{$user->account_balance}} VND</p>
				@endif
				<a href="#">+ Nạp tiền vào tài khoản</a>
			</div>
		</div>
		<div class="profile-wr-right">
			<table>
				<tr>
					<td class="pro-t">Full Name</td>
					<td>{{$student->name}}</td>
				</tr>
				<tr>
					<td class="pro-t">Gender</td>
					<td>{{$student->gender}}</td>
				</tr>
				<tr>
					<td class="pro-t">Birthday</td>
					<td>{{$student->birthday}}</td>
				</tr>
				<tr>
					<td class="pro-t">Address</td>
					<td>{{$student->address}}</td>
				</tr>
				<tr>
					<td class="pro-t">Phone Number</td>
					<td>{{$student->phone}}</td>
				</tr>
				<tr>
					<td class="pro-t">Email Address</td>
					<td>{{$user->email}}</td>
				</tr>
			</table>
		</div>
		@endif
	</div>
	
</fieldset>
<fieldset>
	<legend>Ghi danh khóa học</legend>
	<div class="tablelist listQa">
		<div class="fill">
			<div class="fill-left">
				<input type= "text" class="searchFil" id="searchFill" placeholder="Search...">
			</div>
		</div>
		<div class="table-body">
			<table>
				<thead>
					<tr>
						<th class="code">#</th>
						<th class="i_crs">Mã khóa học</th>
						<th class="n_crs">Tên khóa học</th>
						<th class="d_crs">Trình độ</th>
						<th class="status">Trạng thái</th>
						<th class="f_crs">Chức năng</th>
					</tr>
				</thead>
				<tbody id="table-q">
					@if(isset($regcourse))
					@foreach($regcourse as $key=>$reg)
					@if($reg->id_student == $student->id)
					<tr>
						@foreach($course as $c)
						@if($c->id == $reg->id_course)
						<td class="code">{{$key + 1}}</td>
						<td  class="i_crs">{{$c->id}}</td>
						<td>{{$c->name}}</td>
						<td>
							@foreach($type as $t)
							@if($t->id == $c->id_ctype)
								@foreach($category as $cate)
								@if($cate->id == $t->id_category)
									{{$cate->name}}
								@endif
								@endforeach

								{{$t->level}}
							@endif
							@endforeach 
						</td>
						<td class="status">{{$c->status}}</td>
						<td>
							<ul class="menu-dropdown">
							    <li class="taction">Action</li>
								<li class="dropdown-child">
									<ul>
										<li><a href="admin/course/edit/{{$c->id}}">Detail</a></li>
									</ul>
								</li>
							</ul>
						</td>
						
						@endif
						@endforeach
					</tr>
					@endif
					@endforeach
					@endif
				</tbody>
			</table>
		</div>
	</div>
</fieldset>
@endsection
@section('script')
<script type="text/javascript">
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
</script>
@endsection