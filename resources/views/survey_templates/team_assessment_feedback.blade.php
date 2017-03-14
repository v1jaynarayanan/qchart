@extends('layouts.app')

@section('content')
<div class="container sub-page">
    <h1>
        Team Assessment
    </h1>
    @if (session('status'))
    <div class="alert alert-success">
        {{ session('status') }}
    </div>
    @endif
    <form action="{{ url('/createNewSurvey') }}" method="POST" name="newSurveyForm" role="form">
        {{ csrf_field() }}
        <div class="formMainRow">
            <div class="form-row">
                <label class="required-label">
                    Survey Title
                </label>
                <input class="textBox" id="surveyTitle" name="surveyTitle" type="text" value="{{ old('surveyTitle') }}"/>
            </div>
            <div class="form-row">
                <label class="required-label">
                    Survey Description
                </label>
                <input class="textBox" id="surveyDescription" name="surveyDescription" type="text" value="{{ old('surveyDescription') }}"/>
            </div>
            <div class="info-message">
                Answers will be a value between 1 (low / bad) and 10 (high / good)
            </div>
            <div class="form-row new-question">
                <label class="qnsLabel required-label">
                    Question
                    <span class="qns-count">
                        1
                    </span>
                </label>
                <input class="textBox" name="question1" type="text" value=" {{ !empty(old('question1')) ? old('question1') : 'Do you think the team produced value to business?' }}"/>
            </div>
            <div class="form-row new-question">
                <label class="qnsLabel required-label">
                    Question
                    <span class="qns-count">
                        2
                    </span>
                </label>
                          <input class="textBox" name="question2" type="text" value=" {{ !empty(old('question2')) ? old('question2') : 'Did the team welcome changes to requirements?' }}"/>
                <span class="remove-question">
                    <i aria-hidden="true" class="fa fa-times">
                    </i>
                </span>
            </div>
            <div class="form-row new-question">
                <label class="qnsLabel required-label">
                    Question
                    <span class="qns-count">
                        3
                    </span>
                </label>
                       <input class="textBox" name="question3" type="text" value=" {{ !empty(old('question3')) ? old('question3') : 'How well do you think the team colloborated?' }}"/>
                <span class="remove-question">
                    <i aria-hidden="true" class="fa fa-times">
                    </i>
                </span>
            </div>
            <div class="form-row new-question">
                <label class="qnsLabel required-label">
                    Question
                    <span class="qns-count">
                        4
                    </span>
                </label>
                        <input class="textBox" name="question4" type="text" value=" {{ !empty(old('question4')) ? old('question4') : 'Did the team members trust each other?' }}"/>
                <span class="remove-question">
                    <i aria-hidden="true" class="fa fa-times">
                    </i>
                </span>
            </div>
            <div class="form-row new-question">
                <label class="qnsLabel required-label">
                    Question
                    <span class="qns-count">
                        5
                    </span>
                </label>
                        <input class="textBox" name="question5" type="text" value=" {{ !empty(old('question5')) ? old('question5') : 'Was there enough face to face communication with in the team?' }}"/>
                <span class="remove-question">
                    <i aria-hidden="true" class="fa fa-times">
                    </i>
                </span>
            </div>
            <div class="form-row new-question">
                <label class="qnsLabel required-label">
                    Question
                    <span class="qns-count">
                        6
                    </span>
                </label>
                      <input class="textBox" name="question6" type="text" value=" {{ !empty(old('question6')) ? old('question6') : 'Does the team focus on achieving technical excellence?' }}"/>
                <span class="remove-question">
                    <i aria-hidden="true" class="fa fa-times">
                    </i>
                </span>
            </div>
            <div class="form-row new-question">
                <label class="qnsLabel required-label">
                    Question
                    <span class="qns-count">
                        7
                    </span>
                </label>
                      <input class="textBox" name="question7" type="text" value=" {{ !empty(old('question7')) ? old('question7') : 'Did the team reflect on its performance?' }}"/>
                <span class="remove-question">
                    <i aria-hidden="true" class="fa fa-times">
                    </i>
                </span>
            </div>
            <div class="form-row new-question">
                <label class="qnsLabel required-label">
                    Question
                    <span class="qns-count">
                        8
                    </span>
                </label>
                      <input class="textBox" name="question8" type="text" value=" {{ !empty(old('question8')) ? old('question8') : 'Do you think the team is self organised?' }}"/>
                <span class="remove-question">
                    <i aria-hidden="true" class="fa fa-times">
                    </i>
                </span>
            </div>
            <div id="addNewQuestionDiv">
                <a href="javascript:void(0);" id="addNewQuestion">
                    <i aria-hidden="true" class="fa fa-plus-circle">
                    </i>
                    Add new question
                </a>
            </div>
            <button class="btn" disabled="" id="addNewSurvey" type="submit">
                Submit
            </button>
        </div>
    </form>
</div>
<script type="text/javascript">
 // setup js count
    var template_count = 8;
    var template_countLimit = 8; 
</script>
@endsection
