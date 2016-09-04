@extends('layouts.inner')

@section('content')
<div class="container sub-page">
		<h1>Send survey</h1>
		@if (isset($surveyDetails) && !empty($surveyDetails))
			@foreach ($surveyDetails as $i => $value)
				<h3>You can invite people to complete your survey <b>{{ $value->title }}</b>.</h3>
				<h5>Type in the email ids of the people who you wish to send this survey to.</h5><br>
				@if (session('status'))
		            <div class="alert alert-success">
		              {{ session('status') }}
				    </div>
		 		@endif
		 		<form class="form-horizontal sendSurveyForm" role="form" method="POST" action="{{ url('/survey/sendEmail') }}">
		        	{{ csrf_field() }}
		           	<div>
						<label for="email">E-Mail Addresses</label>
							
						<input id="email" type="textbox" class="inputMaterial" name="email" value="{{  old('email') }}" size="500" required>
						<span class="highlight"></span>
						<span class="bar"></span>
					</div>
					<div class="groupNoMargin">
		              <label>Type comma to seperate multiple email addresses</label>
		           </div>
		           <div class="groupNoMargin clearfix">
		              	<button type="submit" class="btn fR">
		              		<i class="fa fa-btn fa-envelope"></i> Send Survey To Users
		              	</button>
		           </div>
		           <input type="hidden" name="surveyId" value="{{ $value->survey_id }}">
		        </form> 
    		@endforeach	      
    	@endif  
	</div>			
@endsection
