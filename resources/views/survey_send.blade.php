@extends('layouts.inner')

@section('content')
			<div class="sub-page">
			 	<div id="loginContainer">
       				 <div id="sendSurvey">
						<h1>Send Survey</h2>
						@if (isset($surveyDetails) && !empty($surveyDetails))
							@foreach ($surveyDetails as $i => $value) 
								<h4>You can invite people to complete your survey <b>{{ $value->title }}</b>.</h4>
					        	<h5>Type in the email ids of the people who you wish to send this survey to.</h5> 

								@if (session('status'))
					                <div class="alert alert-success">
			    		              {{ session('status') }}
			            		    </div>
			             		@endif

			             <form class="form-horizontal" role="form" method="POST" action="{{ url('/survey/sendEmail') }}">
			                {{ csrf_field() }}
			                   <div class="groupNoMargin{{ $errors->has('email') ? ' has-error' : '' }}">
			                    	<label for="email">E-Mail Addresses</label>
			                      	@if ($errors->has('email'))
			                        	<span class="help-block">
			                            	<strong>{{ $errors->first('email') }}</strong>
			                         	</span>
			                         @endif
			                      <input id="email" type="email" class="inputMaterial" name="email" value="{{  old('email') }}" size="500" required>
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
				</div>        
		</div>
			
		
@endsection
