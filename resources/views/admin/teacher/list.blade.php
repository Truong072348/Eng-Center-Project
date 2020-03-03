@extends('admin.layout.index')
@section('style')
<link rel="stylesheet" type="text/css" href="css/teacher.css">
@endsection
@section('breadbrum')
<div class="breadcrumb">
	<ul class="clear-fix">
		<li><a><i class="fas fa-home"></i> Dashboard</a></li>
		<li>Teachers</li>
	</ul>
</div>
@endsection

@section('title')
<div class="page-title">
	<h1><img src="Images/folder.png">Teachers</h1>
</div>
@endsection

@section('search')
<div class="container-search">
	<div class="search">
		<form method="POST" action="{{Route('searchTeacher')}}">
			<input type="hidden" name="_token" value="{{csrf_token()}}">
			<input type="text" name="search" placeholder="Search for name">
			<button type="submit"><i class="fas fa-search"></i></button>
			
		</form>
	</div>
	<div class="add">
		<a href="admin/teacher/add">+ Add Teacher</a>
	</div>
</div>
@endsection
@section('content')
@foreach ($teacher as $tc)
<div class="box">
	<div class="box-img">
		<div class="img">
			<a href="admin/teacher/edit/{{$tc->id}}"><img src="{{$tc->avatar}}"></a>	
		</div>
		<div class="social-wr">
			<ul class="social clear-fix">
				<li><img src="Images/mess.png"></li>
			</ul>
		</div>
	</div>
	<div class="box-body">
		<p class="box-title">
			<span id="name-teacher">
				{{$tc->name}}
			</span>
		</p>
		<p class="box-info"><span id="adr">{{$tc->address}}</span></p>
		<p class="box-info"><span id="skill">{{$tc->degree}}</span></p>
		<p class="box-info"><span id="phone">{{$tc->phone}}</span></p>
		<p class="box-info"><span id="email">{{$tc->email}}</span></p>
		<p class="box-desc"><span id="short-intro">
			{{$tc->slogan}}
		</span></p>

		<a href="admin/teacher/edit/{{$tc->id}}">Learn more</a>
	</div>
</div>
@endforeach

<div class="pagination-wr">
	{!!$teacher->links()!!}
</div>

@endsection
