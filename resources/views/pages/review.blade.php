@extends('pages.index')
@section('style')
<link rel="stylesheet" type="text/css" href="{{ secure_asset('css/overview.css') }}">
<link rel="stylesheet" type="text/css" href="{{ secure_asset('css/review.css') }}">
<!-- <link rel="stylesheet" type="text/css" href="css/review.css"> -->
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
					<form method="POST" action="postQuiz/{{$courseTest->id}}" id="form-test">
						<input type="hidden" name="_token" value="{{csrf_token()}}">
						<input type="hidden" name="idtest" value="{{$courseTest->id}}">
						
						@if($type == 1)
						@if(!empty($detailBasic))
						
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
										
										<?php $first = '<li class="correct-answer"><input type="radio" name="answer'.($basic->id).'" value="'.$basic->correct.'" disabled><span>'.$basic->correct.'</span></li>';?>
										<?php $second = '<li><input type="radio" name="answer'.($basic->id).'" value="'.$basic->answer1.'" disabled><span>'.$basic->answer1.'</span></li>'; ?>
										<?php $third = '<li><input type="radio" name="answer'.($basic->id).'" value="'.$basic->answer2.'" disabled><span>'.$basic->answer2.'</span></li>'; ?>
										<?php $fourth = '<li><input type="radio" name="answer'.($basic->id).'" value="'.$basic->answer3.'" disabled><span>'.$basic->answer3.'</span></li>'; ?>
										<ul class="group-answer">
											
											@foreach($studyTestDetail as $detail)
						
											@if($detail->id_question == $basic->id && $detail->sole == 1)
												
											@if($detail->answer == $basic->answer1)
											<?php $second = '<li class="error"><input type="radio" name="answer'.($basic->id).'" value="'.$basic->answer1.'" disabled checked><span>'.$basic->answer1.'</span></li>'; ?>
											@elseif($detail->answer == $basic->answer2)
											<?php $third = '<li class="error"><input type="radio" name="answer'.($basic->id).'" value="'.$basic->answer2.'" disabled checked><span>'.$basic->answer2.'</span></li>'; ?>
											@elseif ($detail->answer == $basic->answer3)
											<?php $fourth = '<li class="error"><input type="radio" name="answer'.($basic->id).'" value="'.$basic->answer3.'" disabled checked><span>'.$basic->answer3.'</span></li>'; ?>
											@elseif($detail->answer == $basic->correct)
											<?php $first = '<li class="correct-answer"><input type="radio" name="answer'.($basic->id).'" value="'.$basic->correct.'" disabled checked><span>'.$basic->correct.'</span></li>';?> 
												
											@endif
											@endif

											@endforeach
											@php($rand = rand(1, 4))
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
											@elseif ($rand == 3)
											<?php echo $third?>
											<?php echo $second?>
											<?php echo $first?>
											<?php echo $fourth?>
											@else
											<?php echo $third?>
											<?php echo $second?>
											<?php echo $fourth?>
											<?php echo $first?>
											@endif
											<div class="correct">
												Correct Answer: {{$basic->correct}}
											</div>
											
										</ul>
									</div>
								</div>
							</div>
							
							@endforeach
							<input type="hidden" name="type" value="2">
							@if(count($questionPara) > 0)
							<a class="nextQuestion">Tiếp theo</a>
							@endif
						</div>
						
						@endif
						@elseif($type == 2)
						@if(!empty($questionPara))
						<div class="qs-wr">
							<div class="wr-para">
								<h3>Paragraph Questions Section</h3>
								@foreach($questionPara as $key=>$para)
								<div class="number">Question {{$key + 1}}</div>
								<div class="content">
									{{$para->content['content']}}
								</div>
								<input type="hidden" name="basic" value="3">

								@foreach($detailPara as $detail)
								@foreach($detail as $d)
								@if($d->id_question == $para->id_question)
								<div class="test-content-question">
									<div class="c-question-content">
										<div class="question paragraph">
										{{$d->question}}
										</div>
										<div class="answer">
											<ul class="group-answer">
												<?php $first = '<li class="correct-answer"><input type="radio" name="answer'.$d->id.'" value="'.$d->correct.'" disabled><span>'.$d->correct.'</span></li>';?>
												<?php $second = '<li><input type="radio" name="answer'.$d->id.'" value="'.$d->answer1.'" disabled><span>'.$d->answer1.'</span></li>'; ?>
												<?php $third = '<li><input type="radio" name="answer'.$d->id.'" value="'.$d->answer2.'" disabled><span>'.$d->answer2.'</span></li>'; ?>
												<?php $fourth = '<li><input type="radio" name="answer'.$d->id.'" value="'.$d->answer3.'" disabled><span>'.$d->answer3.'</span></li>'; ?>

												@foreach($studyTestDetail as $test_detail)
										
												@if($test_detail->id_question == $d->id)
												@if($test_detail->answer == $d->answer1)
												<?php $second = '<li class="error"><input type="radio" name="answer'.($d->id).'" value="'.$d->answer1.'" disabled checked><span>'.$d->answer1.'</span></li>'; ?>
												@elseif($test_detail->answer == $d->answer2)
												<?php $third = '<li class="error"><input type="radio" name="answer'.($d->id).'" value="'.$d->answer2.'" disabled checked><span>'.$d->answer2.'</span></li>'; ?>
												@elseif ($test_detail->answer == $d->answer3)
												<?php $fourth = '<li class="error"><input type="radio" name="answer'.($d->id).'" value="'.$d->answer3.'" checked  disabled><span>'.$d->answer3.'</span></li>'; ?>
												@elseif($test_detail->answer == $d->correct)
												<?php $first = '<li class="correct-answer"><input type="radio" name="answer'.($d->id).'" value="'.$d->correct.'" disabled checked><span>'.$d->correct.'</span></li>';?>
												@else
												@endif

												@endif
												@endforeach	

												@php($rand = rand(1, 4))
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
												<div class="correct">
													Correct Answer: {{$d->correct}}
												</div>
											</ul>
											
											<input type="hidden" name="question[]" value="">
										</div>
									</div>
								</div>
								@endif
								@endforeach
								@endforeach
						
								@endforeach
								@if(!empty($questionAudio))
								<a class="nextQuestion">Tiếp theo</a>
								@else
								<input type="hidden" name="basic" value="2">
								@endif
							</div>
							@endif
						</div>
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
								<input type="hidden" name="basic" value="2">
								@foreach($detailAudio as $detail)
								@foreach($detail as $d)
								@if($d->id_question == $audio->id_question)
								<div class="test-content-question">
									<div class="c-question-content">
										<div class="question paragraph">
										{{$d->question}}
										</div>
										<div class="answer">
											<ul class="group-answer">
												<?php $first = '<li class="correct-answer"><input type="radio" name="answer'.$d->id.'" value="'.$d->correct.'" disabled><span>'.$d->correct.'</span></li>';?>
												<?php $second = '<li><input type="radio" name="answer'.$d->id.'" value="'.$d->answer1.'" disabled><span>'.$d->answer1.'</span></li>'; ?>
												<?php $third = '<li><input type="radio" name="answer'.$d->id.'" value="'.$d->answer2.'" disabled><span>'.$d->answer2.'</span></li>'; ?>
												<?php $fourth = '<li><input type="radio" name="answer'.$d->id.'" value="'.$d->answer3.'" disabled><span>'.$d->answer3.'</span></li>'; ?>
												
												@foreach($studyTestDetail as $test_detail)
												@if($test_detail->id_question == $d->id)
												@if($test_detail->answer == $d->answer1)
												<?php $second = '<li class="error"><input type="radio" name="answer'.($d->id).'" value="'.$d->answer1.'" disabled checked><span>'.$d->answer1.'</span></li>'; ?>
												@elseif($test_detail->answer == $d->answer2)
												<?php $third = '<li class="error"><input type="radio" name="answer'.($d->id).'" value="'.$d->answer2.'" disabled checked><span>'.$d->answer2.'</span></li>'; ?>
												@elseif ($test_detail->answer == $d->answer3)
												<?php $fourth = '<li class="error"><input type="radio" name="answer'.($d->id).'" value="'.$d->answer3.'" disabled checked><span>'.$d->answer3.'</span></li>'; ?>
												@elseif($test_detail->answer == $d->correct)
												<?php $first = '<li class="correct-answer"><input type="radio" name="answer'.($d->id).'" value="'.$d->correct.'" disabled checked><span>'.$d->correct.'</span></li>';?>
												@else
												@endif

												@endif
												@endforeach	

												@php($rand = rand(1, 4))
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
												<div class="correct">
													Correct Answer: {{$d->correct}}
												</div>
											</ul>
											
											<input type="hidden" name="question[]" value="">
										</div>
									</div>
								</div>
								@endif
								@endforeach
								@endforeach
						
								@endforeach
							</div>
							@endif
						</div>
						@endif
					</form>
				</div>
				<div class="total-question">
					<div class="time-test">Test submitted<span id="time">{{$result->time}}  </span> early</div>
					<div class="list-q">
						@if(count($questionBasic) > 0)
						<input type="hidden" name="basicCount" value="{{count($questionBasic)}}">
						@endif
						@if(count($questionPara) > 0)
						<input type="hidden" name="paraCount" value="{{count($questionPara)}}">
						@endif
						@if(count($questionAudio) > 0)
						<input type="hidden" name="paraAudio" value="{{count($questionAudio)}}">
						@endif
						<ul class="clear-fix">
						</ul>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
@section('script')
<script src="{{ secure_asset('js/review.js') }}"></script>
<script src="{{ secure_asset('js/page-index.js') }}"></script>
<!-- <script src="js/review.js"></script> -->
<!-- <script src="js/page-index.js"></script> -->
@endsection