@extends('pages.index')
@section('style')
<link rel="stylesheet" type="text/css" href="{{ secure_asset('css/overview.css') }}">
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
						@if(count($questionBasic) > 0)
						<div class="qs-wr">
							<h3>Basic Questions Section</h3>
							@foreach($questionBasic as $key=>$basic)
							<div class="test-content-question basic">
								<div class="c-question-number">
									Question<span>{{$key + 1}}</span>
								</div>
								<div class="c-question-content">
									<div class="question">
										{{$basic[0]->question}}
									</div>
									<div class="answer">
										<ul class="group-answer">
											<?php $first = '<li><input type="radio" name="answer'.($basic[0]->id).'" value="'.$basic[0]->correctAnswer.'"><span>'.$basic[0]->correctAnswer.'</span></li>';?>
											<?php $second = '<li><input type="radio" name="answer'.($basic[0]->id).'" value="'.$basic[0]->answer1.'"><span>'.$basic[0]->answer1.'</span></li>'; ?>
											<?php $third = '<li><input type="radio" name="answer'.($basic[0]->id).'" value="'.$basic[0]->answer2.'"><span>'.$basic[0]->answer2.'</span></li>'; ?>
											<?php $fourth = '<li><input type="radio" name="answer'.($basic[0]->id).'" value="'.$basic[0]->answer3.'"><span>'.$basic[0]->answer3.'</span></li>'; ?>
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
										<input type="hidden" name="question[]" value="{{$basic[0]->id}}">
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
						@if(count($questionPara) > 0)
						<div class="qs-wr">
							<div class="wr-para">
								<h3>Paragraph Question Section</h3>
								@foreach($questionPara as $key=>$para)
								<div class="number">Question {{$key + 1}}</div>
								<div class="content">
									{{$para[0]->content}}
								</div>
								@foreach($detailPara as $detail)
								@if($detail[0]->id_question == $para[0]->id)
								@foreach($detail as $d)
								<div class="test-content-question">
									<div class="c-question-content">
										<div class="question paragraph">
											{{$d->question}}
										</div>
										<div class="answer">
											
											<ul class="group-answer">
												<?php $first = '<li><input type="radio" name="answer'.$d->id.'" value="'.$d->correctAnswer.'"><span>'.$d->correctAnswer.'</span></li>';?>
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
								@endforeach
								@endif
								@endforeach
								@endforeach
							</div>
							<input type="hidden" name="type" value="3">
							<input type="hidden" name="basic" value="2">
							@if(count($questionAudio) > 0)
							<a class="nextQuestion">Tiếp theo</a>
							@endif
							@if(count($questionAudio) == 0)
							<div class="btn-group">
								<div class="btn-login">
									<button type="submit">Nộp bài</button>
								</div>
							</div>
							@endif
						</div>
						@endif
						@else
						@if(count($questionAudio) > 0)
						<div class="qs-wr">
							<div class="wr-para">
								<h3>Audio Question Section</h3>
								@foreach($questionAudio as $key=>$audio)
								<div class="number">Question {{$key + 1}}</div>
								<div class="content">
									<audio class="audio-content" controls>
										<source src="upload/audio/{{$audio[0]->content}}" type="audio/mpeg">
									</audio>
								</div>
								<input type="hidden" name="basic" value="2">
								@foreach($detailAudio as $detail)
								@if($detail[0]->id_question == $audio[0]->id)
								@foreach($detail as $d)
								<div class="test-content-question">
									<div class="c-question-content">
										<div class="question paragraph">
											{{$d->question}}
										</div>
										<div class="answer">
											
											<ul class="group-answer">
												<?php $first = '<li><input type="radio" name="answer'.$d->id.'" value="'.$d->correctAnswer.'"><span>'.$d->correctAnswer.'</span></li>';?>
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
								@endforeach
								@endif
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
						<input type="hidden" name="time" >
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
				<p>Bạn muốn thoát? Kết quả bài thi sẽ chỉ bao gồm phần trước đó</p>
				<a class="out-submit" id="autoSubmit" rel="modal:close">Xác nhận</a>
			</div>
		</div>
	</div>
</div>
@endsection
@section('script')
<script type="text/javascript">
	$(document).ready(function(){
		var listQs = $('input[name=basicCount]').val();
		var listPara = $('input[name=paraCount]').val();
		var listAudio = $('input[name=paraAudio]').val();
		var $arrAnswer = [];
		$(document).on("change", "input[type='radio']", function(){
			$answer = $(this).val();
			$idq = $(this).closest('.group-answer').next().val();
			var exsist = false;
			for(var i in $arrAnswer){
				if($arrAnswer[i].id == $idq){
					$arrAnswer[i].answer = $answer;
					exsist = true
					break;
				}
			}
			if(exsist == false) {
				$arrAnswer.push({answer: $answer, id: $idq});
			}
			console.log($arrAnswer);
			
		});
	$(document).on('click','.nextQuestion', function(){
		var $type = $('input[name=type]').val();
		var $id = $('input[name=idtest]').val();
		var $time = $('input[name=time]').val();
		
			$.ajax({
			url: 'test/' + $id,
			type: 'get',
			data: {
				_type: $type
			},
			
			success: function(data){
				var $content = $(data).find('.qs-wr').html();
				$('.qs-wr').empty().html($content);
			},
			error: function(e){
				$('.form-type').html('<p>Load Error!!!<p>');
						console.log(e.message);
					}
				});
				
				$.ajax({
					url: 'postQuiz/' + $id,
					type: 'post',
					data: {
						"_token": "{{ csrf_token() }}",
						_arrAnswer: $arrAnswer,
						_time: $time, 
						_type: $type
					},
					
					success: function(data){
						
					}
				});
			});
			var timer2 = $('#time').text();
			var interval = setInterval(function() {
			var timer = timer2.split(':');
			var minutes = parseInt(timer[0], 10);
			var seconds = parseInt(timer[1], 10);
			--seconds;
			minutes = (seconds < 0) ? --minutes : minutes;
			seconds = (seconds < 0) ? 59 : seconds;
			seconds = (seconds < 10) ? '0' + seconds : seconds;
			
			$('.time-test span').html(minutes + ':' + seconds);
			$('input[name=time]').val('00:' + minutes +':'+ seconds);
			if (minutes < 0) clearInterval(interval);
			if ((seconds <= 0) && (minutes <= 0)) {
				clearInterval(interval);
				$('#form-test').submit();
			}
			timer2 = minutes + ':' + seconds;
			}, 1000);
			if(listQs > 0) {
				$('.list-q ul').append('<span class="typeQuestion">Basic Question</span>')
			}
			for(var i = 0; i<listQs; i++){
				var number;
				if (i < 10) {
					number = '<li><a href="#">0'+(i + 1)+'</a></li>';
				}
				else {
					number = '<li><a href="#">'+(i+ 1)+'</a></li>';
				}
				$('.list-q ul').append(number);
			};
			if(listPara > 0){
				$('.list-q ul').append('<span class="typeQuestion">Paragraph Question</span>')
			}

			for(var i = 0; i<listPara; i++){
				var number;
				if (i < 10) {
					number = '<li><a href="#">0'+(i + 1)+'</a></li>';
				}
				else {
					number = '<li><a href="#">'+(i + 1)+'</a></li>';
				}
				$('.list-q ul').append(number);
			}

			if(listAudio > 0){
				$('.list-q ul').append('<span class="typeQuestion">Audio Question</span>')
			}

			for(var i = 0; i<listAudio; i++){
				var number;
				if (i < 10) {
					number = '<li><a href="#">0'+(i + 1)+'</a></li>';
				}
				else {
					number = '<li><a href="#">'+(i + 1)+'</a></li>';
				}
				$('.list-q ul').append(number);
			}
		});
</script>
<script src="{{ secure_asset('js/page-index.js') }}"></script>
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