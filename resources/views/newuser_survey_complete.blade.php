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

        <form class="form-horizontal" role="form" action="{{ url('/submit/newUserSurveyResponse') }}" method="POST" name="newUserSubmitSurveyResponseForm" />
        
            {{ csrf_field() }}

            @if (isset($surveyDetails) && !empty($surveyDetails))
                @foreach ($surveyDetails as $i => $value) 
                    <div class="clearfix">
                        <h3>Welcome to QChart. Please fill out your answers for the survey:</h3><h2 class="fL">{{ $value->title }}</h2>
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
                    <th>Your Name: <input id="name" type="text" class="inputMaterial" name="name" value="{{ old('name') }}"></th>
                    <th><label class="required-label">Your Email:</label><input id="email" type="email" class="inputMaterial" name="email" value="{{ $email }}" required></th>
                </tr>
                <tr>
                    <td><input id="password" type="password" class="inputMaterial" name="password" required>
                        <span class="highlight"></span>
                        <span class="bar"></span>
                        <label for="password">Password</label>
                        @if ($errors->has('password'))
                            <span class="help-block">
                                <strong>{{ $errors->first('password') }}</strong>
                            </span>
                        @endif
                    </td>
                    </td>
                </tr>
            </table>
            <table>
                <tr>
                    <td><b>If the name is left blank then your response will be sent anonymously. Please enter name and password if you wish to register with QChart.</b></td>
                </tr>
            </table>        
             <div class="group clearfix">
                <button type="submit" class="btn fR" id="submitBtn">
                  <i class="fa fa-btn fa-user"></i> Submit Answers
                </button>
             </div>
        </form>     
    </div>

@endsection
