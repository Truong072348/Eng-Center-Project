@extends('admin.layout.index')
@section('style')
<link rel="stylesheet" type="text/css" href="css/teacher.css">
<link rel="stylesheet" type="text/css" href="css/question.css">
@endsection
@section('breadbrum')
<div class="breadcrumb">
	<ul class="clear-fix">
		<li><a><i class="fas fa-home"></i> Dashboard</a></li>
		<li><a href="admin/student/list">Students</a></li>
		<li>Add Student</li>
	</ul>
</div>
@endsection
@section('title')
<div class="page-title">
	<h1><img src="Images/folder.png">Students</h1>
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
	<form method="POST" action="admin/student/add" class="form-submit" enctype="multipart/form-data">
		<input type="hidden" name="_token" value="{{csrf_token()}}">
		<div class="form-left">
			<div class="form-group">
				<input type="text" name="name" placeholder="Họ Tên" value="{{old('name')}}">
				@if($errors->has('name'))
				<div class="notify-error">
					{{$errors->first('name')}}
				</div>
				@endif
			</div>
			<div class="form-group">
				<input type="date" name="date"  value="{{old('date')}}">
				@if($errors->has('date'))
				<div class="notify-error">
					{{$errors->first('date')}}
				</div>
				@endif
			</div>
			<div class="form-group select-style">
				<i class="fas fa-chevron-down"></i>
				<select id="sex" name="sex" value="{{old('sex')}}">
					<option value="0">Nam</option>
					<option value="1">Nữ</option>
				</select>
			</div>
			<div class="form-group">
				<input type="tel" name="phone" placeholder="Phone" value="{{old('phone')}}">
				@if($errors->has('phone'))
				<div class="notify-error">
					{{$errors->first('phone')}}
				</div>
				@endif
			</div>
			<div class="form-group">
				<input type="email" name="email" placeholder="Email" value="{{old('email')}}">
				@if($errors->has('email'))
				<div class="notify-error">
					{{$errors->first('email')}}
				</div>
				@endif
			</div>
			<div class="form-group">
				<input type="text" name="address"  placeholder="Address" value="{{old('address')}}">
				@if($errors->has('address'))
				<div class="notify-error">
					{{$errors->first('address')}}
				</div>
				@endif
			</div>
			<div class="account-w">
				<div class="title-wr">
					<h3>Account Information</h3>
				</div>
				<div class="form-group">
					<input type="text" name="user" placeholder="Username" value="{{old('user')}}" >
					@if($errors->has('user'))
					<div class="notify-error">
						{{$errors->first('user')}}
					</div>
					@endif
				</div>
				<div class="form-group">
					<input type="password" name="pass" placeholder="Password" value="{{old('pass')}}">
					@if($errors->has('pass'))
					<div class="notify-error">
						{{$errors->first('pass')}}
					</div>
					@endif
				</div>
				<div class="form-group">
					<input type="password" name="cfpass" placeholder="Confirm Password">
					@if($errors->has('cfpass'))
					<div class="notify-error">
						{{$errors->first('cfpass')}}
					</div>
					@endif
				</div>
			</div>
		</div>
		<div class="form-right">
			<div class="img-preview">
				<img src="Images/male-define.jpg" id="preview">
			</div>
			
			<div class="form-group input-group">
				<label><img src="./Images/download-1.png">
					<p>
						Drop image here or click to upload </br>
						
					</p>
				</label>
				<input type="file"  accept="image/*" name="avatar" value="{{old('avatar')}}" id="imgInput">
			</div>
		</div>
		<div class="btn-group">
			<button type="submit">Submit</button>
		</div>
	</form>
</fieldset>
@endsection
@section('script')
<script type="text/javascript">
	var reader = new FileReader();
		reader.onload = function(e){
			$('#preview').attr('src', e.target.result);
		}
		function readURL(input){
			if(input.files && input.files[0]){
				reader.readAsDataURL(input.files[0]);
			}
		}
		$('#imgInput').on('change', function(){
			readURL(this);
		});
</script>
@endsection