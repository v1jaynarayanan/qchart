@extends('layouts.app')

@section('content')
<div class="container sub-page">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <h1>Add New Survey Confirmation</h1>
                <h3>Your new survey has been created successfully.</h3>

                 @if (isset($surveyDetails) && !empty($surveyDetails))

	             <h4>You can now send survey link to people and invite them to complete your survey</h4><br><a href="{{URL::to('/')}}/sendSurvey/{{$surveyDetails->id}}" class="btn">Send Survey</a>
            @endif
            </div>
        </div>
    </div>
</div>
@endsection