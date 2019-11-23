@extends('admin.layout.index')
@section('style')
<link rel="stylesheet" type="text/css" href="css/teacher.css">
<link rel="stylesheet" type="text/css" href="css/question.css">
<link rel="stylesheet" type="text/css" href="css/student.css">
<link rel="stylesheet" type="text/css" href="css/course.css">
@endsection
@section('breadbrum')
<div class="breadcrumb">
	<ul class="clear-fix">
		<li><a><i class="fas fa-home"></i> Dashboard</a></li>
		<li><a href="admin/course/list">Courses</a></li>
		<li>{{$course->name}}</li>
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
	@if($course->status == 'opening')
	<div class="active-course">
		<a href="admin/course/close/{{$course->id}}">Opening</a>
	</div>
	@elseif($course->status == 'waitting')
	<div class="active-course">
		<a href="admin/course/active/{{$course->id}}">Waitting</a>
	</div>
	@else 
	<div class="active-course">
		<a href="admin/course/waitting/{{$course->id}}">Closed</a>
	</div>
	@endif
	<div class="add">
		<a href="admin/lesson/add/{{$course->id}}">+ Add Lesson</a>
	</div>
</div>
@endsection
@section('content')
<fieldset>
	@if(session('notify'))
	<div class="alert alert-success">
		{{session('notify')}}
	</div>
	@endif
	<div class="title-wr">
		<h3>Basic Information</h3>
	</div>
	@if(isset($course))
	<form method="POST" action="admin/course/edit/{{$course->id}}" class="form-submit"  enctype="multipart/form-data">
		<input type="hidden" name="_token" value="{{csrf_token()}}">
		<div class="form-left">
			<div class="form-group">
				<input type="text" name="name" placeholder="Tên khóa học" value="{{$course->name}}">
				@if($errors->has('name'))
				<div class="notify-error">
					{{$errors->first('name')}}
				</div>
				@endif
			</div>
			<div class="form-group">
				<input type="name" name="shortdesc" placeholder="Giới thiệu ngắn" value="{{$course->short_description}}">
				@if($errors->has('shortdesc'))
				<div class="notify-error">
					{{$errors->first('shortdesc')}}
				</div>
				@endif
			</div>
			<div class="form-group">
				<label>Giới thiệu khóa học</label>
				<textarea name="txtContent" class="form-control " id="editor1">{{$course->description}}</textarea>
				@if($errors->has('txtContent'))
				<div class="notify-error">
					{{$errors->first('txtContent')}}
				</div>
				@endif
			</div>
			<div class="form-group select-style">
				<i class="fas fa-chevron-down"></i>
				<select name="category" id="category" required>
					@if(isset($categoryList))
					@foreach($categoryList as $c)
					<option value="{{$c->id}}" {{$c->id == $category->id ? 'selected=selected ' : ''}}>{{$c->name}}</option>
					@endforeach
					@endif
				</select>
			</div>
			<div class="form-group select-style">
				<i class="fas fa-chevron-down"></i>
				<select name="level" value="{{$course->id_ctype}}" id="level">
					
					@if(isset($type, $typeList))
					@foreach($typeList as $tl)
					@if($tl->id_category == $category->id)
					<option value="{{$tl->id}}" {{$type->id == $tl->id ? 'selected=selected' : ''}}>{{$tl->level}}</option>
					@endif
					@endforeach
					@endif
				</select>
			</div>
			<div class="form-group">
				<input type="number" name="fee" value="{{$course->price}}" placeholder="Học phí">
				@if($errors->has('fee'))
				<div class="notify-error">
					{{$errors->first('fee')}}
				</div>
				@endif
			</div>
			<div class="form-group">
				<label>Giáo viên</label>
				@foreach($teacher as $tc)
				@if($tc->id == $course->id_teacher)
				
				<input id="teacher" disabled value="{{$tc->name}} - {{$course->id_teacher}}">
				@endif
				@endforeach
				<input type="hidden" name="idteacher" id="idteacher" value="{{$course->id_teacher}}">
				@if($errors->has('idteacher'))
				<div class="notify-error">
					{{$errors->first('idteacher')}}
				</div>
				@endif
			</div>
		</div>
		<div class="form-right">
			<div class="img-wr-right">
				<img src="Images/{{$course->image}}" id="preview">
			</div>
			<div class="form-group input-group">
				<label><img src="./Images/download-1.png">
					<p>
						Drop image here or click to upload </br>
						
					</p>
				</label>
				<input type="file" name="image" id="imgInput">
			</div>
			@if($errors->has('image'))
			<div class="notify-error">
				{{$errors->first('image')}}
			</div>
			@endif
			<div class="form-group">
				<label>Ngày bắt đầu</label>
				<input type="date" name="start" value="{{$course->date_start}}">
				@if($errors->has('start'))
				<div class="notify-error">
					{{$errors->first('start')}}
				</div>
				@endif
			</div>
			<div class="form-group">
				<label>Ngày kết thúc</label>
				<input type="date" name="finish" value="{{$course->date_finish}}">
			</div>
		</div>
		<!-------------------------table------------------------------>
		<div class="check-container">
			<input type="checkbox" id="check">
			<span>Update Teacher</span>
		</div>
		<div class="teacher-wr">
			<div class="fill">
				<div class="fill-left">
					<input type= "text" class="searchFil" id="searchFill" placeholder="Search for...">
				</div>
			</div>
			<div class="table-wr" style="min-height: 300px">
				<table id="mytable">
					<thead>
						<tr>
							<th class="av">Photo</th>
							<th class="n">Name</th>
							<th class="de" id='degree_header'>Trình Độ <img src="Images/sort.png"></th>
							<th class="cr" id='course_header'>Khóa học <img src="Images/sort.png"></th>
							<th id='work_header'>working <img src="Images/sort.png"></th>
							<th class="action">Action</th>
						</tr>
					</thead>
					<tbody id="table-q">
						@if(isset($teacher))
						@foreach($teacher as $tch)
						<tr>
							<td class="av"><img src="Images/{{$tch->avatar}}"></td>
							<td class="n"><a href="admin/teacher/edit/{{$tch->id}}">{{$tch->name}}</a></td>
							<td class="de" style="text-transform: capitalize;">{{$tch->degree}}</td>
							<td class="cr">
								@if(isset($courseList))
								@php ($i = 0)
								@foreach($courseList as $kc=>$crs)
								
								<ul>
									@if($crs->id_teacher == $tch->id)
									<li>{{$crs->name}}</li>
									@php ($i = $i + 1)
									@endif
								</ul>
								@endforeach
								@endif
							</td>
							<td class="work {{$i >= 2 ? 'red' : 'green'}}"><span></span>{{$i >= 2 ? 'High' : 'Low'}}</td>
							<td class="code">{{$tch->id}}</td>
							<td class="action">
								<a class="select-name">Select</a>
							</td>
						</tr>
						@endforeach
						@endif
					</tbody>
				</table>
			</div>
		</div>
		<div class="btn-group">
			<button type="submit">Edit</button>
		</div>
	</form>
	@endif
</fieldset>
@endsection
@section('script')
<script src="js/question.js"></script>
<script src="js/course.js"></script>
<script type="text/javascript">
	$(document).ready(function(){
		$('.teacher-wr').hide();
		$('#check').on('change', function(){
			$(this).parent().next('.teacher-wr').slideToggle();
		});


	  $("#searchFill").on("keyup", function() {
	    var value = $(this).val().toLowerCase();
	    $("#table-q tr").filter(function() {
	      $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
	    });
	  });


	});
</script>
@endsection