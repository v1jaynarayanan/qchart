{{ Auth::user()->name }} has closed the survey {{ $surveyTitle }}. <br>

Thank you for sending your response for this survey. <br>

Click this link to view the survey results <a href="{{ $url }}">{{ $url }}</a> <br>

Questions asked in the survey were: <br>

@if (isset($questions) && !empty($questions))
 <table>
 	<tr>
        <th>Id</th>
        <th>Question</th>
    </tr>
    @foreach ($questions as $i => $value) 
        <tr>
            <td>{{ ++$ }}</td>
            <td>{{ $value->question }}</td>
        </tr>   
    @endforeach
 </table>   
@endif  