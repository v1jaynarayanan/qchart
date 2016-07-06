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
                            <a href="{{URL::to('/')}}/drawGraph/{{$value->survey_id}}" class="btn survey-btn fR">Generate Graph</a>
                        </td>    
                        @endif
                    </tr>
                @endforeach
            @endif        
        </table>
        
    </div>
@endsection
