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
	<div class="alert alert-success">
		{{session('error')}}
	</div>
	@endif
	<form method="POST" method="admin/question/add" class="form-submit"  enctype="multipart/form-data">
		<input type="hidden" name="_token" value="{{csrf_token()}}">
		<div class="select-group">
			<div class=" form-type select-style">
				<div class="title-wr">
					<h3>Select category</h3>
				</div>
				<div class="form-group">
					<i class="fas fa-chevron-down"></i>
					<select id="typecate" name="category" required>
						@foreach($category as $c)
						<option value="{{$c->id}}">{{$c->name}}</option>
						
						@endforeach
					</select>
				</div>
			</div>
			<div class=" form-type select-style">
				<div class="title-wr">
					<h3>Select types of question</h3>
				</div>
				<div class="form-group">
					<i class="fas fa-chevron-down"></i>
					<select id="type" name="type" required>
						@foreach($qtype as $t)
						@if(session('page'))
						<option @if(session('page') == $t->id) selected @endif value="{{$t->id}}">{{$t->name}}</option>
						@else
						<option value="{{$t->id}}">{{$t->name}}</option>
						@endif
						@endforeach
					</select>
				</div>
			</div>
		</div>
		@if(session('page'))
		<div class="form-group contentQ">
			@if(session('page') == 2)
			<input type="file" accept="audio/*" name="audio" required>
			@elseif(session('page') == 3)

			@else
			<textarea name="content" class="form-control " id="editor1"></textarea>
			@if($errors->has('content'))
			<div class="notify-error">
				{{$errors->first('content')}}
			</div>
			@endif
			@endif
		</div>
		@else
		<div class="form-group contentQ">
			<textarea name="content" class="form-control " id="editor1"></textarea>
			@if($errors->has('content'))
			<div class="notify-error">
				{{$errors->first('content')}}
			</div>
			@endif
		</div>
		@endif
		<div class="qa-wr">
			<div class="qa-group">
				<h3>Question 1</h3>
				<div class="form-group">
					<input type="text" name="ques1" placeholder="Question">
					@if($errors->has('ques1'))
					<div class="notify-error">
						{{$errors->first('ques1')}}
					</div>
					@endif
				</div>
				<div class="qa-group-wr">
					<div class="qa-g-left">
						<div class="form-group">
							<input type="text" name="cransewr1" placeholder="Correct Answer">
							@if($errors->has('cransewr1'))
							<div class="notify-error">
								{{$errors->first('cransewr1')}}
							</div>
							@endif
						</div>
						<div class="form-group">
							<input type="text" name="as1_1" placeholder="Answer">
						</div>
						@if($errors->has('as1_1'))
						<div class="notify-error">
							{{$errors->first('as1_1')}}
						</div>
						@endif
					</div>
					<div class="qa-g-right">
						<div class="form-group">
							<input type="text" name="as1_2" placeholder="Answer">
							@if($errors->has('as1_2'))
							<div class="notify-error">
								{{$errors->first('as1_2')}}
							</div>
							@endif
						</div>
						<div class="form-group">
							<input type="text" name="as1_3" placeholder="Answer">
							@if($errors->has('as1_3'))
							<div class="notify-error">
								{{$errors->first('as1_3')}}
							</div>
							@endif
						</div>
					</div>
				</div>
			</div>
		</div>
		<a id="addQ">Add Question & answer</a>
		<div class="btn-group">
			<button type="submit">Submit</button>
		</div>
	</form>
</fieldset>
@endsection
@section('script')
<script src="js/question.js"></script>
@endsection