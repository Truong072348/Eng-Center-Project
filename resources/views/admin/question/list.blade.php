@extends('admin.layout.index')
@section('style')
<link rel="stylesheet" type="text/css" href="question.css">
@endsection
@section('breadbrum')
<div class="breadcrumb">
	<ul class="clear-fix">
		<li><a><i class="fas fa-home"></i> Dashboard</a></li>
		<li>Questions</li>
	</ul>
</div>
@endsection
@section('title')
<div class="page-title">
	<h1><img src="Images/folder.png">Questions</h1>
</div>
@endsection
@section('search')
<div class="container-search">
	<div class="add">
		<a href="admin/question/add">+ Add Question</a>
	</div>
</div>
@endsection
@section('content')
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
						<th class="parafuc">
						Action</th>
					</tr>
				</thead>
			</table>
			<div class="qs-table-wr">
				@foreach($question as $key=>$q)
				<table class="table-2">
					<tbody id="table-q">
						<tr>
							<td class="id">{{$key+1}}</td>
							<td class="content">
								{{$q->content}}
							</td>
							@foreach($category as $k=>$c)
							@if($category[$k]->id == $q->id_category)
							<td class="paraType">{{$category[$k]->name}}</br>{{$q->id}}</td>
							@endif
							@endforeach
							<td class="parafuc"><a href="admin/question/edit/{{$q->id}}" class="EditTo">Edit</a></td>
						</tr>
						
					</tbody>
				</table>
				<table class="table-answer">
					<tbody >
						@if(isset($questionDetail))
						@foreach($questionDetail as $qas)
						@if($qas->id_question == $q->id)
						<tr>
							<td class="id"></td>
							<td class="question">{{$qas->question}}</td>
							<td class="answer">{{$qas->correct}}</td>
							<!-- <td class="parafuc"><a href="#" class="EditTo">Edit</a></td> -->
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
						<th class="parafuc">Action</th>
					</tr>
				</thead>
			</table>
			<div class="qs-table-wr">
				@if(isset($question))
				@foreach($question as $key=>$q)
				<table class="table-2" id="mytable">
					<tbody id="table-q">
						<tr>
							<td class="id">{{$key + 1}}</td>
							<td class="content"><audio controls>
								<!-- <source src="horse.ogg" type="audio/ogg"> -->
								<source src="{{$q->content}}">
							</audio></td>
							@foreach($category as $k=>$c)
							@if($category[$k]->id == $q->id_category)
							<td class="paraType">{{$category[$k]->name}}</td>
							@endif
							@endforeach
							<td class="parafuc"><a href="admin/question/edit/{{$q->id}}" class="EditTo">Edit</a></td>
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
							<td class="answer">{{$qas->correct}}</td>
							<!-- <td class="parafuc"><a href="#" class="EditTo">Edit</a></td> -->
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
			@elseif($idT == 3)
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
								<th class="stt" style="width: 5%;">#</th>
								<th class="type">Type</th>
								<th class="bqes" style="width: 30%;">Question</th>
								<th class="basw" style="width: 25%;">Answer</th>
								<th class="fuc" style="width: 10%">Action</th>
							</tr>
						</thead>
						<tbody id="table-q">
							@php($i = 0)
							@foreach($basic as $bs)
							<tr>
								<td class="id">{{$i = $i + 1}}</td>
								@foreach($category as $cate)
								@if($cate->id == $bs->id_category)
								<td class="type" style="text-align: center;">{{$cate->name}}</td>
								@endif
								@endforeach
								<td>{{$bs->question}}</td>
								<td>{{$bs->correct}}</td>
								<td class="fuc"><a href="admin/question/edit/{{$bs->id}}" class="EditTo">Edit</a></td>
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
		<a href="admin/question/add" class="addQues">Add Question</a>
	</div>
</div>
@endsection
@section('script')
<script src="js/ajaxLoadQuestion.js"></script>
<script type="text/javascript">
	$(document).ready(function(){
	  $(document).on("keyup","#searchFill", function() {
	    var value = $(this).val().toLowerCase();
	    $("#table-q tr").filter(function() {
	      $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
	    });
	  });
});
</script>
@endsection