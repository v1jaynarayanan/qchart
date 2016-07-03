@extends('layouts.app')

@section('content')
<div class="container sub-page">
    <div class="clearfix">
        <h1 class="fL">Survey Dashboard</h1>
        @if (Auth::user()->role_id == 0)
        <a href="#" class="btn survey-btn fR">Add New Survey</a>
        @endif
    </div>
    <table class="table">
        <tr>
            <th width="30">S.No.</th>
            <th>Survey Title</th>
            <th>Created By</th>
            <th>Survey Status</th>
            <th>Created Date Time</th>
            <th>Updated Date Time</th>
            @if (Auth::user()->role_id == 0)
                <th width="90">&nbsp;</th>
            @endif
        </tr>
        @if (isset($surveys) && !empty($surveys))
            @foreach ($surveys as $i => $value) 
            <tr>
                <td>{{ ++$i }} </td>
                <td><a href="#">{{ $value->title }}</a></td>
                <td>{{ $value->name }}</td>
                <td>{{ $value->status == 1 ? 'Open' : 'Closed' }}</td>
                <td>{{ $value->created_at }}</td>
                <td>{{ $value->updated_at }}</td>
                @if (Auth::user()->role_id == 0)
                    <td><a href="#" class="btn delete-btn">Delete</a></td>
                @endif
            </tr>
            @endforeach
        @endif    
    </table>
</div>
@endsection
