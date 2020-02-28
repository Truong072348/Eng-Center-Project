@extends('admin.layout.index')
@section('style')
<link rel="stylesheet" type="text/css" href="css/teacher.css">
<link rel="stylesheet" type="text/css" href="css/question.css">
<link rel="stylesheet" type="text/css" href="css/course.css">
@endsection
@section('breadbrum')
<div class="breadcrumb">
	<ul class="clear-fix">
		<li><a><i class="fas fa-home"></i> Dashboard</a></li>
		<li><a href="admin/course/list">Courses</a></li>
		<li><a href="admin/course/edit/{{$course->id}}">{{$course->name}}</a></li>
		<li>Lesson</li>
	</ul>
</div>
@endsection
@section('title')
<div class="page-title">
	<h1><img src="Images/folder.png">Courses: {{$course->name}}</h1>
</div>
@endsection
@section('search')
<div class="container-search">
	<div class="add">
		<a href="admin/course/test/{{$course->id}}">+ Add Test</a>
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
		<h3>Upload Lesson</h3>
	</div>
	<form method="POST" action="admin/lesson/add/{{$course->id}}" class="form-submit"  enctype="multipart/form-data">
		<input type="hidden" name="_token" value="{{csrf_token()}}">
		<div class="form-left">
			<div class="form-group">
				<input type="text" name="name" placeholder="Title" value="{{old('name')}}">
				@if($errors->has('name'))
				<div class="notify-error">
					{{$errors->first('name')}}
				</div>
				@endif
			</div>
			<div class="form-group">
				<label>URL Video</label>
				<input type="file" name="video" accept="video/*" class="file_multi_video" value="{{old('video')}}">
				@if($errors->has('video'))
				<div class="notify-error">
					{{$errors->first('video')}}
				</div>
				@endif
			</div>
			<div class="form-group">
				<label>URL Document</label>
				<input type="file" name="document" accept="file_extension">
				@if($errors->has('document'))
				<div class="notify-error">
					{{$errors->first('document')}}
				</div>
				@endif
			</div>
		</div>
		<div class="form-right">
			<div class="video">
				<video controls>
					<source src="" id="video_here">
					Your browser does not support HTML5 video
				</video>
				
			</div>
		</div>
		<div class="btn-group">
			<button type="submit">Confirm</button>
		</div>
	</form>
</fieldset>
<div class="list-wr">
	<div class="tablelist listQa">
		<div class="title-wr">
			<h3>Danh sách bài giảng</h3>
		</div>
		<div class="fill-wr">
			<span class="row_q" style="margin-bottom: 0; padding-left: 5px">
				{{$lesson->count()}} of 10 record per page
				
			</span>
			<div class="fill-right">
				<form method="POST" action="{{Route('searchLesson')}}">
					<input type="hidden" name="_token" value="{{csrf_token()}}">
					<input type="hidden" name="id_course" value="{{$course->id}}">
					<input type= "text" class="searchFil" name="search" id="searchFill" placeholder="Search for name">
				</form>
			</div>
		</div>
		<div class="type_c" style="float: left; margin: 5px 0 15px 0">
			<ul class="menu-dropdown" id="select-type">
				<li>Select Lesson</li>
				<li class="dropdown-child">
					<ul>
						<li><a href="admin/lesson/add/{{$course->id}}">All</a></li>
					</ul>
				</li>
			</ul>
		</div>
		<div class="qa-wr" id="result">
			<div class="table">
				<table>
					<thead>
						<tr>
							<th class="ltitle">Title</th>
							<th class="lvideo">Video</th>
							<th class="ldoc">Document</th>
							<th class="laction">Actions</th>
						</tr>
					</thead>
					<tbody id="table-q">
						@if(isset($lessons))
						@foreach($lessons as $less)
						<tr>
							
							<td>{{$less->lesson}}</td>
							<td>{{$less->links_svideo}}</td>
							<td>{{$less->links_document}}</td>
							<td class="laction">
								<ul class="menu-dropdown">
									<li class="taction">Action
									</li>
									<li class="dropdown-child">
										<ul>
											<li><a href="admin/lesson/edit/{{$less->id}}">Edit</a></li>
											<li><a href="admin/lesson/delete/{{$course->id}}/{{$less->id}}">Delete</a></li>
										</ul>
									</li>
								</ul>
							</td>
						</tr>
						@endforeach
						@endif
					</tbody>
				</table>
			</div>
			<span class="row_q">Showing {{$lesson->firstItem()}} to {{$lesson->lastItem()}} of {{$lesson->total()}} entries</span>
		</div>
	</div>
	<div class="pagination-wr">
		{!!$lesson->links()!!}
	</div>
	<div class="modal" id="ex5" >
		<p>Khóa học đã kích hoạt. Không thể xóa !!!</p>
	</div>
</div>
@endsection
@section('script')
@if(session('deleteFail'))
<script>
	$('#ex5').modal('open');
</script>
@endif
<script type="text/javascript">
	$(document).on("change", ".file_multi_video", function(evt) {
		var $source = $('#video_here');
		$source[0].src = URL.createObjectURL(this.files[0]);
		$source.parent()[0].load();
		console.log($source.parent()[0]);
	});
	$('.menu-dropdown').on('click', function(){
		$(this).find('.dropdown-child').slideToggle();
	});
</script>
@endsection