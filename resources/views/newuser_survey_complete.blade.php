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
        
        @if (isset($surveyDetails) && !empty($surveyDetails))
            @foreach ($surveyDetails as $i => $value) 
                <div class="clearfix">
                    <h3 class="fL">{{ $value->title }}</h3>
                </div>
            @endforeach         
        @endif
        @if (isset($surveyQuestions) && !empty($surveyQuestions))
            @foreach ($surveyQuestions as $i => $value) 
                <div class="clearfix">
                  <h4 class="fL"> Survey Question {{ ++$i }}</h4>
                </div>  
                <div>
                  <p> {{ $value->question}} </p>
                </div>  
            @endforeach         
        @endif
    </div>

@endsection
