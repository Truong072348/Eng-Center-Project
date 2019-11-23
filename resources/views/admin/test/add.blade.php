@extends('admin.layout.index')
@section('style')
<link rel="stylesheet" type="text/css" href="css/question.css">
<link rel="stylesheet" type="text/css" href="css/test.css">
@endsection
@section('breadbrum')
<div class="breadcrumb">
	<ul class="clear-fix">
		<li><a><i class="fas fa-home"></i> Dashboard</a></li>
		<li><a href="admin/test/list">Tests</a></li>
		<li>Test Add</li>
	</ul>
</div>
@endsection
@section('title')
<div class="page-title">
	<h1><img src="Images/folder.png">Test</h1>
</div>
@endsection
@section('content')
<fieldset>
	@if(session('notify'))
	<div class="alert alert-success">
		{{session('notify')}}
	</div>
	@endif
	@if(session('error'))
	<div class="alert alert-error">
		{{session('error')}}
	</div>
	@endif
	<div class="title-wr">
		<h3>Basic information</h3>
	</div>
	<form method="POST" action="admin/test/add" class="form-submit"  enctype="multipart/form-data">
		<input type="hidden" name="_token" value="{{csrf_token()}}">
		<div class="form-left">
			<div class="head-func">
				<h3>Test Content</h3>
				<a class="deleteAll">Delete All</a>
			</div>
			<!-- 	<div class="form-group select-style">
					<i class="fas fa-chevron-down"></i>
					<select name="level" value="{{old('category')}}" id="level">
										
					</select>
			</div> -->
		</div>
		<div class="form-right">
			<div class="form-group">
				<input type="text" name="name" placeholder="Test name" value="{{old('name')}}">
				@if($errors->has('name'))
				<div class="notify-error">
					{{$errors->first('name')}}
				</div>
				@endif
			</div>
			<div class="form-group">
				<input type="number" name="time" min="0" placeholder="Time (minutes)" value="{{old('time')}}">
				@if($errors->has('time'))
				<div class="notify-error">
					{{$errors->first('time')}}
				</div>
				@endif
			</div>
			<div class="form-group select-style">
				<i class="fas fa-chevron-down"></i>
				<select name="category" value="{{old('category')}}" id="category" required>
					@if(isset($category))
					<option value="" selected>Select category</option>
					@foreach($category as $c)
					<option value="{{$c->id}}">{{$c->name}}</option>
					@endforeach
					@endif
				</select>
			</div>
		</div>
		<div class="wr-test-content" id="testwr">
			
		</div>
		<input type="hidden" name="list">
		<div class="btn-group">
			<button type="submit" id="confirm">Confirm</button>
		</div>
	</form>
</fieldset>
<div class="list-wr">
	<div class="tablelist listQa">
		<div class="form-type select-style q-list-t">
			<div class="title-wr">
				<h3>Select types of question</h3>
			</div>
			<div class="form-group">
				<i class="fas fa-chevron-down"></i>
				<select id="type" name="id" required>
					@if(isset($qtype))
					<option value="">type</option>
					@foreach($qtype as $qt)
					<option value="{{$qt->id}}">{{$qt->name}}</option>
					@endforeach
					@endif
				</select>
			</div>
		</div>
		<div class="qa-wr" id="result">
			@if(isset($idT))
			@if($idT == 1)
			<h3>Paragraph Question</h3>
			<div class="fill">
				<div class="fill-left">
					<input type= "text" class="searchFil" id="searchFill" placeholder="search for question">
				</div>
			</div>
			@if(isset($question))
			<table>
				<thead>
					<tr>
						<th class="id">#</th>
						<th class="content">Content</th>
						<th class="paraType">Type</th>
						<th class="parafuc">Chức năng</th>
					</tr>
				</thead>
			</table>
			<div class="qs-table-wr">
				@foreach($question as $key=>$q)
				<table class="table-2 table-content">
					<tbody class="table-q">
						<tr>
							<td class="id">{{$key+1}}</td>
							<td class="content">
								{{$q->content}}
							</td>
							@foreach($category as $k=>$c)
							@if($category[$k]->id == $q->id_category)
							<td class="paraType">{{$category[$k]->name}}</br><span class="id_question">{{$q->id}}</span></td>
							@endif
							@endforeach
							<td class="parafuc selects"><a class="SelectTo" style="cursor: pointer;">Select</a></td>
						</tr>
						
					</tbody>
				</table>
				<table class="table-answer">
					<tbody class="table-q">
						@if(isset($questionDetail))
						@foreach($questionDetail as $qas)
						@if($qas->id_question == $q->id)
						<tr>
							<td class="id"></td>
							<td class="question">{{$qas->question}}</td>
							<td class="answer">{{$qas->correctAnswer}}</td>
							
						</tr>
						@endif
						@endforeach
						@endif
					</tbody>
				</table>
				@endforeach
				<span class="row_q">Showing {{$question->firstItem()}} to {{$question->lastItem()}} of {{$question->total()}} entries</span>
			</div>
			<div class="pagination-wr">
				{!!$question->links()!!}
			</div>
			@endif
			@elseif($idT == 2)
			<h3>Audio Question</h3>
			<div class="fill">
				<div class="fill-left">
					<input type= "text" class="searchFil" id="searchFill" placeholder="search for question">
				</div>
			</div>
			<table>
				<thead>
					<tr>
						<th class="id">#</th>
						<th class="content">Content</th>
						<th class="paraType">Type</th>
						<th class="parafuc">Chức năng</th>
					</tr>
				</thead>
			</table>
			<div class="qs-table-wr">
				@if(isset($question))
				@foreach($question as $key=>$q)
				<table class="table-2 table-content">
					<tbody class="table-q">
						<tr>
							<td class="id">{{$key + 1}}</td>
							<td class="content">
								<p style="margin-bottom: 10px;">Listent to the audio clip carefull and answer the question: </p>
								<audio controls>
									<source src="upload/video/{{$q->content}}" type="audio/mpeg">
								</audio>
							</td>
							@foreach($category as $k=>$c)
							@if($category[$k]->id == $q->id_category)
							<td class="paraType">{{$category[$k]->name}} <span class="id_question">{{$q->id}}</span></td>
							@endif
							@endforeach
							<td class="parafuc"><a class="SelectTo" style="cursor: pointer;">Select</a></td>
						</tr>
						
					</tbody>
				</table>
				<table class="table-answer">
					<tbody>
						@if(isset($questionDetail))
						@foreach($questionDetail as $qas)
						@if($qas->id_question == $q->id)
						<tr>
							<td class="id"></td>
							<td class="question">{{$qas->question}}</td>
							<td class="answer">{{$qas->correctAnswer}}</td>
							
						</tr>
						@endif
						@endforeach
						@endif
					</tbody>
				</table>
				@endforeach
				@endif
				<span class="row_q">Showing {{$question->firstItem()}} to {{$question->lastItem()}} of {{$question->total()}} entries</span>
				<div class="pagination-wr">
					{!!$question->links()!!}
				</div>
			</div>
			@else
			<h3>Basic Question</h3>
			<div class="fill">
				<div class="fill-left">
					<input type= "text" class="searchFil" id="searchFill" placeholder="search for question">
				</div>
			</div>
			<div class="qa-wr" id="result">
				<div class="table">
					<table>
						<thead>
							<tr>
								<th class="stt">#</th>
								<th class="type">Type</th>
								<th class="bqes">Câu hỏi</th>
								<th class="asw" style="width: 25%;">Đáp án</th>
								<th class="bfunc">Chức năng</th>
							</tr>
						</thead>
						<tbody class="table-q">
							@php($i = 0)
							@foreach($basic as $bs)
							<tr>
								<td class="stt id_question">{{$bs->id}}</td>
								@foreach($category as $cate)
								@if($cate->id == $bs->id_category)
								<td>{{$cate->name}}</td>
								@endif
								@endforeach
								<td class="bqes">{{$bs->question}}</td>
								<td class="asw">{{$bs->correctAnswer}}</td>
								<td class="bfunc"><a class="SelectTo" style="cursor: pointer;">Select</a></td>
							</tr>
							@endforeach
							
						</tbody>
					</table>
				</div>
				<span class="row_q" style="margin: 10px 0; display: inline-block;">Showing {{$basic->firstItem()}} to {{$basic->lastItem()}} of {{$basic->total()}} entries</span>
				<div class="pagination-wr">
					{!!$basic->links()!!}
				</div>
			</div>
			@endif
			
			@endif
		</div>
	</div>
</div>
@endsection
@section('script')
<!-- <script src="js/ajaxAddTest.js"></script> -->
<script src="js/test.js"></script>
<script src="js/course.js"></script>
@endsection