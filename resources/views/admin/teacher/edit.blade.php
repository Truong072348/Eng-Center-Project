@extends('admin.layout.index')
@section('style')
<link rel="stylesheet" type="text/css" href="css/teacher.css">
<link rel="stylesheet" type="text/css" href="css/question.css">
@endsection
@section('breadbrum')
<div class="breadcrumb">
	<ul class="clear-fix">
		<li><a><i class="fas fa-home"></i> Dashboard</a></li>
		<li><a href="admin/teacher/list">Teachers</a></li>
		<li>Edit Teacher</li>
	</ul>
</div>
@endsection
@section('title')
<div class="page-title">
	<h1><img src="Images/folder.png">Teachers</h1>
</div>
@endsection
@section('content')
@section('content')
<fieldset>
	<legend>Thông tin cá nhân</legend>
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
	<form method="POST" action="admin/teacher/edit/{{$teacher->id}}" class="form-submit" enctype="multipart/form-data">
		<input type="hidden" name="_token" value="{{csrf_token()}}">
		<div class="form-left">
			<div class="img-wr">
				@if(isset($teacher))
				<div class="img-wr-left">
					<img src="Images/{{$teacher->avatar}}" id="preview">	
				</div>
				@if(isset($account))
				<div class="img-wr-right">
					<p>Username: <span>{{$account->username}}</span></p>
					<p>ID Account: <span>{{$account->id}}</span></p>
					<p>Surplus: <span>{{$account->account_balance}}</span><span> VND </span><a href="#">Nạp thêm</a></p>
					<p>Date Register: <span>{{$account->created_at}}</span></p>
				</div>
				@endif
				@endif
			</div>
			<div class="form-group">
				<input type="text" name="name" value="{{$teacher->name}}" placeholder="Họ tên">
				@if($errors->has('name'))
				<div class="notify-error">
					{{$errors->first('name')}}
				</div>
				@endif
			</div>
			<div class="form-group">
				<input type="date" name="birth" value="{{$teacher->birth}}">
				@if($errors->has('birth'))
				<div class="notify-error">
					{{$errors->first('birth')}}
				</div>
				@endif
			</div>
			<div class="form-group">
				<input type="tel" name="tel" value="{{$teacher->phone}}" placeholder="Số điện thoại">
				@if($errors->has('tel'))
				<div class="notify-error">
					{{$errors->first('tel')}}
				</div>
				@endif
			</div>
			<div class="form-group">
				<input type="text" name="address" value="{{$teacher->address}}" placeholder="Địa chỉ">
				@if($errors->has('address'))
				<div class="notify-error">
					{{$errors->first('address')}}
				</div>
				@endif
			</div>
			<div class="form-group">
				<input type="text" name="slogan" value="{{$teacher->slogan}}" placeholder="Slogan">
			</div>
			<div class="form-group input-group">
				<label><img src="./Images/download-1.png">
					<p>
						Drop image here or click to upload </br>
						(Upload max filesize 8MB)
					</p>
				</label>
				<input type="file" name="avatar" accept="image/*" value="{{$teacher->avatar}}" id="imgInput">
			</div>
			<div class="change-password">
				<div class="check-container">
					<input type="checkbox" id="check">
					<span> Changes password</span>
				</div>
				<div class="cpass-wr">
					<div class="form-group">
						<input type="password" name="oldpass" placeholder="Mật khẩu cũ">
					</div>
					<div class="form-group">
						<input type="password" name="pass" placeholder="Mật khẩu mới" >
					</div>
					<div class="form-group cfpass">
						<input type="password" name="cfpass" placeholder="Xác nhận lại mật khẩu" >
					</div>
					@if($errors->has('cfpass'))
					<div class="notify-error">
						{{$errors->first('cfpass')}}
					</div>
					@endif
				</div>
			</div>
		</div>
		<div class="form-right">
			<div class="form-group">
				<input type="email" name="email" placeholder="Email" value="{{$account->email}}" disabled>
			</div>
			<div class="form-group select-style">
				<i class="fas fa-chevron-down"></i>
				<select id="sex" name="sex">
					@if($teacher->gender == "Nam")
					<option value="0" selected>Nam</option>
					<option value="1">Nữ</option>
					@else
					<option value="0">Nam</option>
					<option value="1" selected>Nữ</option>
					@endif
				</select>
			</div>
			<div class="form-group">
				<input type="text" name="degree" value="{{$teacher->degree}}" placeholder="Trình độ">
				@if($errors->has('degree'))
				<div class="notify-error">
					{{$errors->first('degree')}}
				</div>
				@endif
			</div>
			<div class="form-group">
				<textarea id="desc" name="intro" placeholder="Giới thiệu">{{$teacher->introduction}}</textarea>
			</div>
		</div>
		<div class="btn-group">
			<button type="submit" id="btn-edit">Edit</button>
		</div>
	</form>
	
</fieldset>
<fieldset>
	<legend>Lịch sử khóa học</legend>
	<div class="tablelist listQa">
		<div class="fill">
			<div class="fill-left">
				<input type= "text" class="searchFil" id="searchFill" placeholder="Search For Course">
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
					@if(isset($course))
					
					@foreach($course as $key=>$cr)
					<tr>
						<td class="code">{{$key + 1}}</td>
						<td class="i_crs">{{$cr->id}}</td>
						<td>{{$cr->name}}</td>

						@if(isset($type, $category))
						
						@foreach($type as $t)
						@php($level = $t->level)
						@endforeach
						@foreach($category as $c)
						@php($name = $c->name)
						@endforeach

						<td>{{$name}} {{$level}}</td>
						@else
						<td></td>
						@endif
						<td class="status green">{{$cr->status}}</td>
						<td class="f_crs"> <a href="admin/course/edit/{{$cr->id}}">Chi tiết</a></td>
					</tr>
					@endforeach
					@endif
				</tbody>
			</table>
		</div>
	</div>
</fieldset>
@endsection
@section('script')
@if(session('passerr'))
	<script>
		$('.cpass-wr').show();
	</script>
@else 
	<script>
		$('.cpass-wr').hide();
	</script>
@endif
<script type="text/javascript">
	$(document).ready(function(){
		
		
		$('#check').change(function(){
			if(this.checked){
				$(this).parent().next('.cpass-wr').slideToggle();
			}
			else
				$(this).parent().next('.cpass-wr').slideToggle();
		});
		$('#btn-edit').on("click", function(){
			if($('.cpass-wr').css('display') == 'block'){
				$('.cpass-wr').css('display','block');
			}
		});

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
	});
</script>
@endsection