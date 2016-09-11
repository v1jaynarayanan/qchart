<!DOCTYPE html>
<html lang="en">
	<body>
	    <header style="background-color: #9ed070;">
	         <div><img src="{{ $message->embed(public_path() . '/images/logo.png') }}" alt="logo" width="100" align="center"/></div>
	    </header>
		
		<h3 style="font-size: 14px; color: #000;"> {{ Auth::user()->name }} has created this survey. It would be great if you could complete this survey. </h3>
			
		<h3 style="font-size: 14px; color: #000;">Click this link to open the survey
		<a href="{{ $url }}">{{ $url }}</a></h3>

		<h3 style="font-size: 14px; color: #000;">Thanks</h3>
		<h3 style="font-size: 14px; color: #000;">QChart</h3>	

	</body>
</html>

