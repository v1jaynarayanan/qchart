<!DOCTYPE html>
<html lang="en">
	<body>
	    <header style="background-color: #9ed070;">
	         <div><img src="{{ $message->embed(public_path() . '/images/logo.png') }}" alt="James Saffron Logo" width="100" align="center"/></div>
	    </header>

		<h3 style="font-size: 14px; color: #000;">{{ Auth::user()->name }} has closed the survey {{ $surveyTitle }}. </h3>

		<h3 style="font-size: 14px; color: #000;">Thank you for sending your response for this survey. </h3>

		<h3 style="font-size: 14px; color: #000;">Click this link to view the survey results <a href="{{ $url }}">{{ $url }}</a> </h3>

		<h3 style="font-size: 14px; color: #000;">Questions asked in the survey were: </h3>

		@if (isset($questions) && !empty($questions))
		 <table style="border:1px solid #CFDAD9; border-collapse: collapse; margin-bottom: 30px; width: 100%;">
		 	<tr>
		        <th style="background-color: #fff; font-weight: 600; text-align: left;">Id</th>
		        <th style="background-color: #fff; font-weight: 600; text-align: left;">Question</th>
		    </tr>
		    @foreach ($questions as $i => $value) 
		        <tr>
		            <th style="border:1px solid #CFDAD9;line-height: 26px !important;text-align: left;">{{ ++$i }}</th>
		            <th style="border:1px solid #CFDAD9;line-height: 26px !important;text-align: left;">{{ $value->question }}</th>
		        </tr>   
		    @endforeach
		 </table>   
		@endif 

		<h3 style="font-size: 14px; color: #000;">Thanks</h3>
		<h3 style="font-size: 14px; color: #000;">QChart</h3>	
 
	</body>
</html>