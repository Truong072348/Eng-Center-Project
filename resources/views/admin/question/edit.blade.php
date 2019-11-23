@extends('admin.layout.index')
@section('breadbrum')
<div class="breadcrumb">
	<ul class="clear-fix">
		<li><a><i class="fas fa-home"></i> Dashboard</a></li>
		<li><a href="admin/question/list">Questions</a></li>
		<li>Question Add</li>
	</ul>
</div>
@endsection
@section('title')
<div class="page-title">
	<h1><img src="Images/folder.png">Questions</h1>
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
	@if(isset($question))
	<form method="POST"  action="admin/question/edit/{{$question->id}}" class="form-submit">
		<input type="hidden" name="_token" value="{{csrf_token()}}">
		<div class="select-group">
			<div class=" form-type select-style">
				<h3>Select types of category</h3>
				<div class="form-group">
					<i class="fas fa-chevron-down"></i>
					<select id="typecate" required>
						@foreach($category as $c)
						<option value="{{$c->id}}" {{$question->id_category == $c->id ? 'selected=selected' : ''}}>{{$c->name}}</option>
						@endforeach
					</select>
				</div>
			</div>
			<input type="hidden" name="type" value="{{$question->id_qtype}}">
			<input type="hidden" name="id" value="{{$question->id}}">
			<div class=" form-type select-style">
				<h3>Select types of question</h3>
				<div class="form-group">
					<i class="fas fa-chevron-down"></i>
					<select id="type" required disabled="">
						@foreach($type as $t)
						<option value="{{$t->id}}" {{$question->id_qtype == $t->id ? 'selected=selected' : ''}}>{{$t->name}}</option>
						@endforeach
					</select>
				</div>
			</div>
		</div>
		@if($question->id_qtype != 3)
		<div class="form-group contentQ">
			@if($question->id_qtype == 1)
			<textarea id="editor1" name="content" required>{{$question->content}}</textarea>
			@if($errors->has('content'))
				<div class="notify-error">
					{{$errors->first('content')}}
				</div>
			@endif
			@else
			<audio controls>
			  <source src="upload/audio/{{$question->content}}" type="audio/mp4">
			Your browser does not support the audio element.
			</audio>
			@endif
		</div>
		@endif
		<div class="qa-wr">
			@if($question->id_qtype == 3)
			<div class="qa-group">
				<h3 class="title">Question </h3>
				<span>/<a class="deleteQ">Delete</a></span>
				<div class="form-group">
					<input type="text" name="ques1" value="{{$question->question}}">
				</div>
				<div class="qa-group-wr">
					<div class="qa-g-left">
						<div class="form-group">
							<input type="text" name="cransewr1" value="{{$question->correctAnswer}}" style="border: 2px solid #ecc">
						</div>
						<div class="form-group">
							<input type="text" name="as1_1" value="{{$question->answer1}}">
						</div>
					</div>
					<div class="qa-g-right">
						<div class="form-group">
							<input type="text" name="as1_2" value="{{$question->answer2}}">
						</div>
						<div class="form-group">
							<input type="text" name="as1_3" value="{{$question->answer3}}">
						</div>
					</div>
				</div>
			</div>
			@else
			@if(isset($qDetail))
			@foreach($qDetail as $key=>$qd)
			<div class="qa-group">
				<h3 class="title">Question {{$key + 1}}</h3>
				<span>/<a class="deleteQ">Delete</a></span>
				<div class="form-group">
					<input type="hidden" name="detail{{$key + 1}}" value="{{$qd->id}}">
					<input type="text" name="ques{{$key + 1}}" value="{{$qd->question}}">
				</div>
				<div class="qa-group-wr">
					<div class="qa-g-left">
						<div class="form-group">
							<input type="text" name="cransewr{{$key+1}}" value="{{$qd->correctAnswer}}" style="border: 2px solid #ecc">
						</div>
						<div class="form-group">
							<input type="text" name="as{{$key+1}}_1" value="{{$qd->answer1}}">
						</div>
					</div>
					<div class="qa-g-right">
						<div class="form-group">
							<input type="text" name="as{{$key+1}}_2" value="{{$qd->answer2}}">
						</div>
						<div class="form-group">
							<input type="text" name="as{{$key+1}}_3" value="{{$qd->answer3}}">
						</div>
					</div>
				</div>
			</div>
			@endforeach
			@endif
			@endif
		</div>
		@if($question->id_qtype != 3)
		<a id="addQ">Add Question & answer</a>
		@endif
		<div class="btn-group">
			<button type="submit">Edit</button>
		</div>
	</form>
	@endif
</fieldset>
@endsection
@section('script')
<script src="js/question.js"></script>
@endsection