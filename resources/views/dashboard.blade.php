@extends('layouts.app')

@section('content')
<div class="container sub-page">
        <div class="clearfix">
            <h1 class="fL">Survey Dashboard</h1>
            @if (Auth::user()->role_id == 0)
            <a href="#" class="btn survey-btn fR">Add New Survey</a>
            @endif
        </div>
        @if (session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
        @endif
        <div align="right">   
            {!! $surveys->render(); !!}
        </div>       

        <form name="dashboardForm" action="{{ url('/deleteSurvey') }}" method="POST">
        {{ csrf_field() }}
        {{ method_field('DELETE') }}
        <table class="table">
            <tr>
                <th width="30"></th>
                <th>S.No.</th>
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
                    <td><input type="checkbox" id="cb{{ $value->id }}" name="cb[]" value="{{ $value->id }}" class="checkbox-btn"></td>
                    <td>{{ ++$i }} </td>
                    <td><a href="{{URL::to('/')}}/details/{{$value->id}}">{{ $value->title }}</a></td>
                    <td>{{ $value->name }}</td>
                    <td>{{ $value->status == 1 ? 'Open' : 'Closed' }}</td>
                    <td>{{ $value->created_at }}</td>
                    <td>{{ $value->updated_at }}</td>
                    @if (Auth::user()->role_id == 0)
                        <td><button type="submit" class="btn fR" onclick="return confirm('Are you sure you want to delete this survey?');">Delete</button>
                        @if ($value->status == 1)
                            <a href="{{URL::to('/')}}/sendSurvey/{{$value->id}}" class="btn survey-btn fR">Send Survey</a>
                        @endif
                        </td>
                    @endif
                </tr>
                @endforeach
            @endif
            <tr>
                <th nowrap>
                    @if (Auth::user()->role_id == 0)
                            <a href="#" class="bt  n delete-btn" onClick="CheckAll(document.dashboardForm.cb)">Check all</a>
 
                    @endif
                </th>
                <th nowrap>
                    @if (Auth::user()->role_id == 0)
                            <button type="submit" class="btn fR" onclick="return confirm('Are you sure you want to delete the selected surveys?');">Delete Selected</button>
 
                    @endif
                </th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                @if (Auth::user()->role_id == 0)
                    <th width="90">&nbsp;</th>
                @endif
            </tr>
        </table>
        <div align="right" nowrap>   
            {!! $surveys->render(); !!}
        </div>
        
        </form>
</div>



@endsection
