@extends('layouts.app')

@section('content')
	<div class="container sub-page">
		<h1>Add New Survey</h1>
		@if (session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
        @endif
		<form name="newSurveyForm" role="form" action="{{ url('/createNewSurvey') }}" method="POST">
			{{ csrf_field() }}
			<div class="formMainRow">
				<div class="form-row">
					<label class="required-label">Survey Title</label>
					<input type="text" class="textBox" id="surveyTitle" name="surveyTitle" value="{{ old('surveyTitle') }}"/>
				</div>
				<div class="form-row">
					<label class="required-label">Survey Description</label>
					<input type="text" class="textBox" id="surveyDescription" name="surveyDescription" value="{{ old('surveyDescription') }}"/>
				</div>
				<div><b>Answers will be a value between 1 (low / bad) and 10 (high / good)</b></div>
				<div class="form-row new-question">
					<label class="qnsLabel required-label">New Question <span class="qns-count">1</span></label>
					<input type="text" class="textBox" name="question1" value="{{ old('question1') }}"/>
				</div>
				<div id="addNewQuestionDiv">
					<a href="javascript:void(0);" id="addNewQuestion"><i class="fa fa-plus-circle" aria-hidden="true"></i> Add new question</a>
				</div>
				<button type="submit" class="btn" id="addNewSurvey" disabled>Submit</button>
			</div>
		</form>
	</div>

@endsection