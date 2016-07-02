@extends('layouts.app')

@section('content')
<div class="container sub-page">
    <div class="clearfix">
        <h1 class="fL">Dashboard</h1>
        <a href="#" class="btn survey-btn fR">Add New Survey</a>
    </div>
    <table class="table">
        <tr>
            <th width="30">S.No.</th>
            <th>Survey Title</th>
            <th>Survey Status</th>
            <th>Created Date Time</th>
            <th>Updated Date Time</th>
            <th width="90">&nbsp;</th>
        </tr>
        @if (isset($surveys) && !empty($surveys))
            @foreach ($surveys as $i => $value) 
            <tr>
                <td>{{ ++$i }} </td>
                <td><a href="#">{{ $value->title }}</a></td>
                <td>{{ $value->status == 1 ? 'Open' : 'Closed' }}</td>
                <td>{{ $value->created_at }}</td>
                <td>{{ $value->updated_at }}</td>
                <td><a href="#" class="btn delete-btn">Delete</a></td>
            </tr>
            @endforeach
        @endif    
    </table>
</div>
@endsection
