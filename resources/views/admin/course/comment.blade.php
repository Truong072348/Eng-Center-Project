@extends('admin.layout.index')
@section('style')
<link rel="stylesheet" type="text/css" href="css/teacher.css">
<link rel="stylesheet" type="text/css" href="css/comment.css">
@endsection
@section('breadbrum')
<div class="breadcrumb">
	<ul class="clear-fix">
		<li><a><i class="fas fa-home"></i> Dashboard</a></li>
		<li><a href="admin/course/list">Courses</a></li>
		<li>Course comment</li>
	</ul>
</div>
@endsection
@section('title')
<div class="page-title">
	<h1><img src="Images/folder.png">Comments</h1>
</div>
@endsection
@section('content')
<div class="list-wr">
	<div class="tablelist listQa">
		<div class="title-wr">
			<h3>Danh sách bình luận</h3>
		</div>
		<div class="fill-wr fill-wr-right">
			<div class="fill-right">
				<input type= "text" class="searchFil" id="searchFill" placeholder="Search Comments">
			</div>
		</div>
		@if(isset($comment))
		<div class="row_q">
			<span id="show_row">{{$comment->count()}}</span> of 
			<select id="select-record">
				<option value="5">5</option>
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
							<th>Author</th>
							<th>Comment</th>
							<th>In Response To</th>
							<th class="action">Action</th>
						</tr>
					</thead>
					<tbody id="table-q">
						
						
			
					</tbody>
				</table>
			</div>
			<span class="row_q" id="show_entry">Showing {{$comment->firstItem()}} to {{$comment->lastItem()}} of {{$comment->total()}} entries</span>
		</div>
		@endif
	</div>
	<div class="pagination-wr">
		{{$comment->links()}}
	</div>
</div>

@endsection
@section('script')
@endsection