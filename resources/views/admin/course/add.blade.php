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
		<li>Courses Add</li>
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
		<h3>Basic Information</h3>
	</div>
	<form method="POST" action="admin/course/add" class="form-submit"  enctype="multipart/form-data">
		<input type="hidden" name="_token" value="{{csrf_token()}}">
		<div class="form-left">
			<div class="form-group">
				<input type="text" name="name" placeholder="Tên khóa học" value="{{old('name')}}">
				@if($errors->has('name'))
				<div class="notify-error">
					{{$errors->first('name')}}
				</div>
				@endif
			</div>
			<div class="form-group">
				<input type="name" name="short_description" placeholder="Giới thiệu ngắn" value="{{old('shortdesc')}}">
				@if($errors->has('shortdesc'))
				<div class="notify-error">
					{{$errors->first('shortdesc')}}
				</div>
				@endif
			</div>
			<div class="form-group">
				<label>Giới thiệu khóa học</label>
				<textarea name="description" class="form-control " id="editor1"></textarea>
				@if($errors->has('txtContent'))
				<div class="notify-error">
					{{$errors->first('txtContent')}}
				</div>
				@endif
			</div>
			<div class="form-group select-style">
				<i class="fas fa-chevron-down"></i>
				<select name="category" value="{{old('category')}}" id="category" required>
					@if(isset($categories))
					<option value="" selected>Select category</option>
					@foreach($categories as $c)
					<option value="{{$c->id}}">{{$c->name}}</option>
					@endforeach
					@endif
				</select>
			</div>
			<div class="form-group select-style">
				<i class="fas fa-chevron-down"></i>
				<select name="id_ctype" value="{{old('category')}}" id="level">
					
				</select>
			</div>
			<div class="form-group">
				<input type="number" name="price" value="{{old('price')}}" placeholder="Học phí">
				@if($errors->has('price'))
				<div class="notify-error">
					{{$errors->first('price')}}
				</div>
				@endif
			</div>
			<div class="form-group">
				<label>Giáo viên</label>
				<input id="teacher" disabled>
				<input type="hidden" name="id_teacher" id="idteacher">
				@if($errors->has('idteacher'))
				<div class="notify-error">
					{{$errors->first('idteacher')}}
				</div>
				@endif
			</div>
		</div>
		<div class="form-right">
			<div class="img-wr-right">
				<img src="Images/banner-1.png" id="preview">
			</div>
			<div class="form-group input-group">

				<label><img src="Images/download-1.png">
					<p>
						Drop image here or click to upload </br>
						
					</p>
				</label>
				<input type="file" name="avatar" value="{{old('avatar')}}" id="imgInput">
			</div>
			@if($errors->has('avatar'))
			<div class="notify-error">
				{{$errors->first('avatar')}}
			</div>
			@endif
			<div class="form-group">
				<label>Ngày bắt đầu</label>
				<input type="date" name="date_start" value="{{old('date_start')}}">
				@if($errors->has('start'))
				<div class="notify-error">
					{{$errors->first('start')}}
				</div>
				@endif
			</div>
			<div class="form-group">
				<label>Ngày kết thúc</label>
				<input type="date" name="date_finish" value="{{old('date_finish')}}">
			</div>
		</div>
		<!-------------------------table------------------------------>
		<div class="teacher-wr">
			<h3>Select teacher</h3>
			<div class="fill">
				<div class="fill-left">
					<input type= "text" class="searchFil" id="searchFill" placeholder="search for...">
				</div>
			</div>
			<div class="table-wr">
				<table>
					<thead>
						<tr>
							<th class="av">Photo</th>
							<th class="n">Name</th>
							<th class="de">Trình Độ</th>
							<th class="cr">Khóa học</th>
							<th class="work">working</th>
							<th class="action">Action</th>
						</tr>
					</thead>
					<tbody id="table-q">
						@if(isset($teachers))
						@foreach($teachers as $tch)
						<tr>
							<td class="av"><img src="{{$tch->avatar}}"></td>
							<td class="n"><a href="admin/teacher/edit/{{$tch->id}}">{{$tch->name}}</a></td>
							<td class="de">{{$tch->degree}}</td>
							<td class="cr">
								@if(isset($courses)) 
								@php ($i = 0)
								@foreach($courses as $kc=>$crs)
								
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
			<button type="submit">Submit</button>
		</div>
	</form>
</fieldset>
@endsection
@section('script')
<script src="js/question.js"></script>
<script src="js/course.js"></script>
@endsection