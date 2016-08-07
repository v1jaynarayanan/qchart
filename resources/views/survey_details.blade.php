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
                <form name="dashboardForm" action="{{URL::to('/')}}/closeSurvey/{{$value->survey_id}}" method="POST">
                {{ csrf_field() }}
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
                            @if ($value->status == 1)
                                <a href="{{URL::to('/')}}/sendSurvey/{{$value->survey_id}}" class="btn survey-btn">Send Survey</a>

                                <a href="#" class="btn" id="deleteSelected">Close Survey</a>
                            @endif 
                        </td>    
                        @endif
                    </tr>
                </form>    
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

        <div id="popUpOverlay">
            <div id="popUp">
                <h4>Are you sure want to close the selected survey?</h4>
                <div class="popBtns clearfix">
                    <a href="#" class="btn" id="confirmBtn">Ok</a>                        
                    <a href="#" class="btn" id="cancelBtn">Cancel</a>
                </div>
            </div>
        </div>    
    </div>
@endsection
