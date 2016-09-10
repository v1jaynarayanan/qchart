@extends('layouts.levelthree')

@section('content')
    <div class="container sub-page">
        <div class="clearfix">
            <h1 class="fL">Complete Survey</h1>
        </div>
        @if (session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
        @endif
         <form class="form-horizontal" role="form" action="{{ url('/submit/activeUserSurveyResponse') }}" method="POST" name="userSubmitSurveyResponseForm" />
        
            {{ csrf_field() }}

            @if (isset($surveyDetails) && !empty($surveyDetails))
                @foreach ($surveyDetails as $i => $value) 
                    <div class="clearfix">
                        <h3>Welcome <b>{{ Auth::user()->name }}</b>. Please fill out your answers for the survey:</h3><h2 class="fL">{{ $value->title }}
                    </div>
                @endforeach         
            @endif
            <br>
            <table class="table">
                    <tr>
                        <th>Id</th>
                        <th>Survey Question</th>
                        <th>Answer <h5>Enter a value between 1 (low / bad) and 10 (high / good)</h5></th>
                    </tr>
                    @if (isset($surveyQuestions) && !empty($surveyQuestions))
                        @foreach ($surveyQuestions as $i => $value) 

                            <tr>
                                <td>{{ ++$i }}</td>
                                <td><label class="required-label"><label class="qnsLabel">{{ $value->question }} </label><input type="hidden" name="question{{ $i}}" value="{{ $value->qid }}"></label></td>
                                <td><div class="form-row new-question">
                                        <select class="selectmenu" name="answer[]" id="answer{{ $i }}"> 
                                                 <option value="" selected="selected"></option>
                                                 <option value="1">1</option>
                                                 <option value="2">2</option>
                                                 <option value="3">3</option>
                                                 <option value="4">4</option>
                                                 <option value="5">5</option>
                                                 <option value="6">6</option>
                                                 <option value="7">7</option>
                                                 <option value="8">8</option>
                                                 <option value="9">9</option>
                                                 <option value="10">10</option>
                                        </select>         
                                    </div>
                                </td>
                            </tr>   
                       

                        @endforeach         
                    @endif
             </table>
             <table class="table">
                <tr>
                    <th>Your Name:</th>
                    <th><input id="name" type="text" class="inputMaterial" name="name" value="{{ Auth::user()->name }}" required></th>
                </tr>
            </table> 
            <div><b>If the name is left blank then your response will be sent anonymously.</b></div>
             <div class="group clearfix">
                <a href="#" class="btn fR" id="submitResponse" onClick="selectValidation(this)">Submit Response</a>
             </div>
             <input type="hidden" name="surveyId" value="{{ $surveyId }}">
        </form>      
    </div>

@endsection
