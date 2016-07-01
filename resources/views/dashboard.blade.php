@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">
                Survey Dashboard
                <a href="#" class="btn survey-btn fR">Add New Survey</a>
                </div>

                <div class="panel-body">
                    
                    <table>
                        <tr>
                            <th width="30">S.No.</th>
                            <th>Survey Title</th>
                            <th>Survey Status</th>
                            <th>Created Date Time</th>
                            <th>Updated Date Time</th>
                            <th width="90">&nbsp;</th>
                        </tr>
                        
                        @foreach ($surveys as $i => $value) 
                        <tr>
                            <td>{{ $i }} </td>
                            <td>{{ $value->title }}</td>
                            <td>{{ $value->status == 1 ? 'Open' : 'Closed' }}</td>
                            <td>{{ $value->created_at }}</td>
                            <td>{{ $value->updated_at }}</td>
                            <td><a href="#" class="btn delete-btn">Delete</a></td>
                        </tr>
                        @endforeach
                </table>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
