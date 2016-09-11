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
                            <a href="{{URL::to('/')}}/drawGraph/{{$value->survey_id}}" class="btn survey-btn">Generate Graph</a><br>
                            @if ($value->status == 1)
                                <a href="{{URL::to('/')}}/sendSurvey/{{$value->survey_id}}" class="btn survey-btn">Send Survey</a> <br>

                                <a href="#" class="btn" id="deleteSelected">Close Survey</a>
                            @endif 
                        </td>    
                        @endif
                    </tr>
                </form>    
                @endforeach
            @endif        
        </table>

        @if (isset($surveyQuestions) && !empty($surveyQuestions))
                <h2>Survey Progress</h2><br>
                <h4>{{ $numOfResponses }}  / {{ $sentTo }} Responses Received</h4>
                
                    <div class="progress-main">
                        <div class="progress-bar-div"></div>
                        <div class="unit-cell"><span>{{ $responsePercent }}</span>%</div>
                    </div>
                
                <br><h2>Survey Questions</h2><br>
                
                <table class="table">
                    <tr>
                        <th>Id</th>
                        <th>Question</th>
                        <th>Created Date Time</th>
                        <th>Updated Date Time</th>
                    </tr>
                        @foreach ($surveyQuestions as $i => $value) 
                        <tr>
                            <td>{{ $value->id }}</td>
                            <td>{{ $value->question }}</td>
                            <td>{{ $value->created_at }}</td>
                            <td>{{ $value->updated_at }}</td>
                        </tr>   
                        @endforeach
                </table>
        @endif  

        @if (isset($users) && !empty($users))
            
            <h2>Survey Participants</h2><br>    
            <table class="table">
                <tr>
                    <th>Id</th>
                    <th>User Name</th>
                    <th>Email</th>
                    <th>Status</th>
                </tr>
                
                    @foreach ($users as $i => $user) 
                        @foreach ($user as $j => $value)
                        <tr>
                            <td>{{ ++$i }}</td>
                            <td>{{ $value->name }}</td>
                            <td>{{ $value->email }}</td>
                            @if ($value->status == 1 )
                                <td class="success-message">Responded</td>
                            @else
                                <td class="error-message">Yet to respond</td>
                            @endif
                        </tr> 
                        @endforeach  
                    @endforeach
            </table>
        @endif

        <div id="popUpOverlay">
            <div id="popUp">
                <h4>Are you sure you want to close the survey? <br><br> All survey respondents will be notified when you close the survey.</h4>
                <div class="popBtns clearfix">
                    <a href="#" class="btn" id="confirmBtn">Ok</a>                        
                    <a href="#" class="btn" id="cancelBtn">Cancel</a>
                </div>
            </div>
        </div>    
    </div>

    <script>
        var percentageValue = <?php echo json_encode($responsePercent); ?>;
    </script>

@endsection
