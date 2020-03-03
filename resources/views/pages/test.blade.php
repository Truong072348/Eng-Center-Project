@extends('pages.index')
@section('style')
<link rel="stylesheet" type="text/css" href="{{ secure_asset('css/overview.css') }}">
<!-- <link rel="stylesheet" type="text/css" href="css/overview.css"> -->
@endsection
@section('content')
<div class="wrapper">
	<div class="row">
		<div class="sm-col-span-12 lg-col-span-4">
			<div class="content-wr-qs">
				<div class="test-content">
					<div class="test-title">
						<h3><span>{{$courseTest->name}}</span></h3>
					</div>
					<form method="POST" action="postQuiz/{{$courseTest->id}}" id="form-answer">
						<input type="hidden" name="_token" value="{{csrf_token()}}">
						<input type="hidden" name="idtest" value="{{$courseTest->id}}">
						@if($type == 1)
						@if(!empty($questionBasic))
						<div class="qs-wr">
							<h3>Basic Questions Section</h3>
							@foreach($detailBasic as $key=>$basic)
							<div class="test-content-question basic">
								<div class="c-question-number">
									Question<span>{{$key + 1}}</span>
								</div>
								<div class="c-question-content">
									<div class="question">
										{{$basic->question}}
									</div>
									<div class="answer">
										<ul class="group-answer">
											<?php $first = '<li><input type="radio" name="answer'.($basic->id).'" value="'.$basic->correct.'"><span>'.$basic->correct.'</span></li>';?>
											<?php $second = '<li><input type="radio" name="answer'.($basic->id).'" value="'.$basic->answer1.'"><span>'.$basic->answer1.'</span></li>'; ?>
											<?php $third = '<li><input type="radio" name="answer'.($basic->id).'" value="'.$basic->answer2.'"><span>'.$basic->answer2.'</span></li>'; ?>
											<?php $fourth = '<li><input type="radio" name="answer'.($basic->id).'" value="'.$basic->answer3.'"><span>'.$basic->answer3.'</span></li>'; ?>
											@php($rand = rand(1, 3))
											@if($rand == 1)
											<?php echo $first?>
											<?php echo $second?>
											<?php echo $third?>
											<?php echo $fourth?>
											@elseif ($rand == 2)
											<?php echo $second?>
											<?php echo $first?>
											<?php echo $fourth?>
											<?php echo $third?>
											@else
											<?php echo $third?>
											<?php echo $second?>
											<?php echo $first?>
											<?php echo $fourth?>
											@endif
										</ul>
										<input type="hidden" name="question[]" value="{{$basic->id}}">
									</div>
								</div>
							</div>
							@endforeach
							<input type="hidden" name="type" value="2">
							@if(count($questionPara) > 0 || count($questionAudio) > 0)
							<a class="nextQuestion">Tiếp theo</a>
							@else
							<input type="hidden" name="basic" value="1">
							@endif
						</div>
						@if(count($questionPara) == 0 && count($questionAudio) == 0)
						<div class="btn-group">
							<div class="btn-login">
								<button type="submit">Nộp bài</button>
							</div>
						</div>
						@endif
						@endif
						
						@elseif($type == 2)
						@if(!empty($questionPara))
						<div class="qs-wr">
							<h3>Paragraph Questions Section</h3>
							@foreach($questionPara as $key=>$para)
								<div class="number">Question {{$key + 1}}</div>
								<div class="content">
									{{$para->content['content']}}
								</div>
								@foreach($detailPara as $detail)
								@foreach($detail as $stt=>$d)
								@if($d->id_question == $para->id_question)
								
								<div class="test-content-question">
									<div class="c-question-content">
										<div class="question paragraph">
										{{$stt + 1}}. {{$d->question}}
										</div>
										<div class="answer">
											<ul class="group-answer">
												<?php $first = '<li><input type="radio" name="answer'.$d->id.'" value="'.$d->correct.'"><span>'.$d->correct.'</span></li>';?>
												<?php $second = '<li><input type="radio" name="answer'.$d->id.'" value="'.$d->answer1.'"><span>'.$d->answer1.'</span></li>'; ?>
												<?php $third = '<li><input type="radio" name="answer'.$d->id.'" value="'.$d->answer2.'"><span>'.$d->answer2.'</span></li>'; ?>
												<?php $fourth = '<li><input type="radio" name="answer'.$d->id.'" value="'.$d->answer3.'"><span>'.$d->answer3.'</span></li>'; ?>
												@php($rand = rand(1, 3))
												@if($rand == 1)
												<?php echo $first?>
												<?php echo $second?>
												<?php echo $third?>
												<?php echo $fourth?>
												@elseif ($rand == 2)
												<?php echo $second?>
												<?php echo $first?>
												<?php echo $fourth?>
												<?php echo $third?>
												@else
												<?php echo $third?>
												<?php echo $second?>
												<?php echo $first?>
												<?php echo $fourth?>
												@endif
											</ul>
											<input type="hidden" name="question[]" value="{{$d->id}}">
										</div>
									</div>
								</div>
								@endif
								@endforeach
								@endforeach
							@endforeach
							<input type="hidden" name="type" value="3">
							@if(!empty($questionAudio))
							<a class="nextQuestion">Tiếp theo</a>
							@else
							<input type="hidden" name="basic" value="2">
							@endif
						</div>
						@if(count($questionAudio) == 0)
						<div class="btn-group">
							<div class="btn-login">
								<button type="submit">Nộp bài</button>
							</div>
						</div>
						@endif

						@endif
						@else
						@if(!empty($questionAudio))		
						<div class="qs-wr">
							<div class="wr-para">
								<h3>Audio Question Section</h3>
								@foreach($questionAudio as $key=>$audio)
								<div class="number">Question {{$key + 1}}</div>
								<div class="content">
									<audio class="audio-content" controls>
										<source src="{{$audio->content['content']}}" type="audio/mpeg">
									</audio>
								</div>
								<input type="hidden" name="basic" value="3">
								@foreach($detailAudio as $detail)
								@foreach($detail as $s=>$d)
								@if($d->id_question == $audio->id_question)
								<div class="test-content-question">
									<div class="c-question-content">
										<div class="question paragraph">
										{{$d->question}}
										</div>
										<div class="answer">
											<ul class="group-answer">
												<?php $first = '<li><input type="radio" name="answer'.$d->id.'" value="'.$d->correct.'"><span>'.$d->correct.'</span></li>';?>
												<?php $second = '<li><input type="radio" name="answer'.$d->id.'" value="'.$d->answer1.'"><span>'.$d->answer1.'</span></li>'; ?>
												<?php $third = '<li><input type="radio" name="answer'.$d->id.'" value="'.$d->answer2.'"><span>'.$d->answer2.'</span></li>'; ?>
												<?php $fourth = '<li><input type="radio" name="answer'.$d->id.'" value="'.$d->answer3.'"><span>'.$d->answer3.'</span></li>'; ?>
												@php($rand = rand(1, 3))
												@if($rand == 1)
												<?php echo $first?>
												<?php echo $second?>
												<?php echo $third?>
												<?php echo $fourth?>
												@elseif ($rand == 2)
												<?php echo $second?>
												<?php echo $first?>
												<?php echo $fourth?>
												<?php echo $third?>
												@else
												<?php echo $third?>
												<?php echo $second?>
												<?php echo $first?>
												<?php echo $fourth?>
												@endif
											</ul>
											
											<input type="hidden" name="question[]" value="{{$d->id}}">
										</div>
									</div>
								</div>
								@endif
								@endforeach
								@endforeach
							
								@endforeach
							</div>
							<div class="btn-group">
								<div class="btn-login">
									<button type="submit">Nộp bài</button>
								</div>
							</div>
							@endif
						</div>
						@endif
						<input type="hidden" name="time">
					</form>
				</div>
				<div class="total-question">

					<div class="time-test">Time left<span id="time">{{$test->time}}:00</span></div>
					<div class="list-q">
						
						<input type="hidden" name="basicCount" value="{{count($questionBasic)}}">
						
						<input type="hidden" name="paraCount" value="{{count($questionPara)}}">
						
						<input type="hidden" name="paraAudio" value="{{count($questionAudio)}}">
						
						<ul class="clear-fix">
						</ul>
					</div>
				</div>
			</div>
			<div id="ex2" class="modal">
				<p>Bạn muốn thoát? Kết quả bài thi chỉ được tính những phần đã làm.</p>
				<a class="out-submit" id="autoSubmit" rel="modal:close">Xác nhận</a>
			</div>
		</div>
	</div>
</div>
@endsection
@section('script')
<script src="{{ secure_asset('js/page-test.js') }}"></script>
<script src="{{ secure_asset('js/page-index.js') }}"></script>
<!-- <script src="js/page-index.js"></script> -->
<script>
	$(document).ready(function($) {
	if (window.history && window.history.pushState) {
	window.history.pushState('forward', null, './#forward');
	$(window).on('popstate', function() {
		$('#ex2').modal('open');
		$(document).on('click', '#autoSubmit', function(){
			$('#form-answer').submit();
		});
	});
	}
	});
</script>
@endsection