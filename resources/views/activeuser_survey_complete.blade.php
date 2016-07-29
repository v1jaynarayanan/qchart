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
        <form class="form-horizontal" role="form" method="POST" action="">
            @if (isset($surveyDetails) && !empty($surveyDetails))
                @foreach ($surveyDetails as $i => $value) 
                    <div class="clearfix">
                        <h3>Welcome <b> {{ Auth::user()->name }} </b>. Please fill out your answers for survey:</h3><h2 class="fL">{{ $value->title }}
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
                                <td>{{ $value->question }}</td>
                                <td><input type="textbox" class="textbox"></td>
                            </tr>   
                       

                        @endforeach         
                    @endif
             </table>
             <div class="group clearfix">
                    <button type="submit" class="btn fR" disabled="">
                            <i class="fa fa-btn fa-user"></i> Submit Answers
                    </button>
             </div>
        </form>        
    </div>

@endsection
