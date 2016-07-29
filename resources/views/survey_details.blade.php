@extends('layouts.inner')

@section('content')
    <div class="container sub-page">
        <div class="clearfix">
            <h1 class="fL">Survey Details</h1>
        </div>
        @if (session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
        @endif
        <table class="table">
            <tr>
                <th>Id</th>
                <th>Title</th>
                <th>Description</th>
                <th>Created By</th>
                <th>Status</th>
                <th>Created Date Time</th>
                <th>Updated Date Time</th>
                <th></th>
            </tr>
            @if (isset($surveyDetails) && !empty($surveyDetails))
                @foreach ($surveyDetails as $i => $value) 
                    <tr>
                        <td>{{ $value->survey_id }}</td>
                        <td>{{ $value->title }}</td>
                        <td>{{ $value->description }}</td>
                        <td>{{ $value->name }}</td>
                        <td>{{ $value->status == 1 ? 'Open' : 'Closed' }}</td>
                        <td>{{ $value->created_at }}</td>
                        <td>{{ $value->updated_at }}</td>
                        @if (Auth::user()->role_id == 0)
                        <td>
                            <a href="{{URL::to('/')}}/drawGraph/{{$value->survey_id}}" class="btn survey-btn">Generate Graph</a>
                             <a href="{{URL::to('/')}}/sendSurvey/{{$value->survey_id}}" class="btn">Send Survey</a>
                        </td>    
                        @endif
                    </tr>
                @endforeach
            @endif        
        </table>
        
        <table class="table">
            <tr>
                <th>Id</th>
                <th>Question</th>
                <th>Created Date Time</th>
                <th>Updated Date Time</th>
            </tr>
            @if (isset($surveyQuestions) && !empty($surveyQuestions))
                @foreach ($surveyQuestions as $i => $value) 
                <tr>
                    <td>{{ $value->id }}</td>
                    <td>{{ $value->question }}</td>
                    <td>{{ $value->created_at }}</td>
                    <td>{{ $value->updated_at }}</td>
                </tr>   
                @endforeach
            @endif  
        </table>
    </div>
@endsection
