@extends('layouts.app')

@section('content')
<div class="container sub-page">
        <div class="clearfix">
            <h1 class="fL">Survey Dashboard</h1>
            @if (Auth::user()->role_id == 0)
            <a href="{{URL::to('/')}}/showNewSurveyPage" class="btn survey-btn fR">Create New Survey</a>
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
            <table class="table" id="dashboardTable">
                <tr>
                    <th width="40">&nbsp;</th>
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
                        <td><div class="checkCol"><input type="checkbox" id="cb{{ $value->id }}" name="cb[]" value="{{ $value->id }}"/> <label class="check-label"><i class="fa fa-square-o" aria-hidden="true"></i></label></div>
                        </td>
                        <td>{{ ++$i }} </td>
                        <td><a href="{{URL::to('/')}}/details/{{$value->id}}">{{ $value->title }}</a></td>
                        <td>{{ $value->name }}</td>
                        <td>{{ $value->status == 1 ? 'Open' : 'Closed' }}</td>
                        <td>{{ $value->created_at }}</td>
                        <td>{{ $value->updated_at }}</td>
                        @if (Auth::user()->role_id == 0)
                            @if ($value->status == 1)
                             <td><a href="{{URL::to('/')}}/sendSurvey/{{$value->id}}" class="btn">Send Survey</a></td>
                            @else 
                             <th width="90">&nbsp;</th>
                            @endif    
                        @endif
                    </tr>
                    @endforeach
                @endif
                
            </table>
            <div class="clearfix">
                <div class="fL">
                    <a href="#" class="btn" id="checkAll">Check all</a>
                    @if (Auth::user()->role_id == 0)
                    <a href="#" class="btn" id="deleteSelected">Delete selected</a>
                    @endif
                </div>
                <ul class="pagination fR">
                    {!! $surveys->render(); !!}
                </ul>
            </div>
            <div id="popUpOverlay">
                <div id="popUp">
                    <h4>Are you sure want to delete the selected survey?</h4>
                    <div class="popBtns clearfix">
                        <a href="#" class="btn" id="confirmBtn">Ok</a>
                        <a href="#" class="btn" id="cancelBtn">Cancel</a>
                    </div>
                </div>
            </div>
        </form>
</div>

@endsection
