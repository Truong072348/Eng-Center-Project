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
		<li>Lesson Edit</li>
	</ul>
</div>
@endsection
@section('title')
<div class="page-title">
	<h1><img src="Images/folder.png">Courses</h1>
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
		<h3>Edit Lesson</h3>
	</div>
	<form method="POST" action="admin/lesson/edit/{{$lesson->id}}" class="form-submit"  enctype="multipart/form-data">
		<input type="hidden" name="_token" value="{{csrf_token()}}">
		<div class="form-left">
			<div class="form-group">
				<input type="text" name="name" placeholder="Title" value="{{$course[0]->name}}">
				@if($errors->has('name'))
				<div class="notify-error">
					{{$errors->first('name')}}
				</div>
				@endif
			</div>
			<div class="form-group">
				<label>URL Video</label>
				<input type="file" name="video" accept="video/*" class="file_multi_video" value="{{old('video')}}">
				<p class="show-link video-name">{{$lesson->links_video}}</p>
				@if($errors->has('video'))
				<div class="notify-error">
					{{$errors->first('video')}}
				</div>
				@endif
			</div>
			<div class="form-group">
				<label>URL Document</label>
				<input type="file" name="document" class="file_document" accept="file_extension">
				<p class="show-link document-name">{{$lesson->links_document}}</p>
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
					<source src="{{$lesson->links_svideo}}" id="video_here">
					Your browser does not support HTML5 video
				</video>
				
			</div>
		</div>
		<div class="btn-group">
			<button type="submit">Confirm</button>
		</div>
	</form>
</fieldset>
@endsection
@section('script')
<script type="text/javascript">
	$(document).on("change", ".file_multi_video", function(evt) {
		var $source = $('#video_here');
		$source[0].src = URL.createObjectURL(this.files[0]);
		$source.parent()[0].load();
		
		$('.video-name').hide();
	});

	$(document).on("change", ".file_document", function(evt) {
		$('.document-name').hide();
	});

	$('.menu-dropdown').on('click', function(){
		$(this).find('.dropdown-child').slideToggle();
	});
</script>
@endsection