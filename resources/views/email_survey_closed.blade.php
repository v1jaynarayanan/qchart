{{ Auth::user()->name }} has closed the survey {{ $surveyTitle }}. <br>

Thank you for sending your response for this survey. <br>

Click this link to view the survey results <a href="{{ $url }}">{{ $url }}</a>