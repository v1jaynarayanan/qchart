@extends('layouts.app')

@section('content')
<section>
    <div class="bg-frame">
        <div class="table-row">
            <div class="sub-page">
                <h2>
                    Feedback360 is a free, simple and fast tool that helps you to
                </h2>
                <br/>
                <ul class="common-list">
                    <li>
                        <h4>
                            Create an effective survey online
                        </h4>
                    </li>
                    <li>
                        <h4>
                            Send the survey to recipients to gather information
                        </h4>
                    </li>
                    <li>
                        <h4>
                            Analyse data using a spider graph
                        </h4>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</section>
<!--break divider -->
<div class="break_divider">
</div>
<div class="container">
    <div class="row">
        <div class="col-lg-12 text-center">
            <h2 class="section-heading">
                Feedback Templates
            </h2>
            <br/>
            <h3 class="section-heading">
                Check out our pre-built feedback templates and questions
            </h3>
            <br/>
        </div>
        <div class="col-xs-12 col-sm-6 col-lg-4">
            <div class="box">
                <div class="icon">
                    <div class="image">
                        <span class="fa fa-area-chart btn-lg white">
                        </span>
                    </div>
                    <div class="info">
                        <h3 class="title">
                            Agile Sprint Retrospective
                        </h3>
                        <p>
                        </p>
                        <div class="more">
                            <a class="preview_a_r" target="_blank" href="{{ url('/template/agile-sprint-retrospective-feedback/preview') }}" id="Preview1" title="">
                                <i class="fa fa-eye">
                                </i>
                                Preview
                            </a>
                            <a class="preview_a_l" href="{{ url('/template/agile-sprint-retrospective-feedback/') }}" title="">
                                <i class="fa fa-external-link">
                                </i>
                                Try This
                            </a>
                        </div>
                    </div>
                </div>
                <div class="space">
                </div>
            </div>
        </div>
        <div class="col-xs-12 col-sm-6 col-lg-4">
            <div class="box">
                <div class="icon">
                    <div class="image">
                        <span class="fa fa-users btn-lg white">
                        </span>
                    </div>
                    <div class="info">
                        <h3 class="title">
                            Team Assessment
                        </h3>
                        <p>
                        </p>
                        <div class="more">
                            <a class="preview_a_r" target="_blank" href="{{ url('/template/team-assessment-feedback/preview') }}" id="Preview2" title="">
                                <i class="fa fa-eye">
                                </i>
                                Preview
                            </a>
                            <a class="preview_a_l" href="{{ url('/template/team-assessment-feedback/') }}" title="">
                                <i class="fa fa-external-link">
                                </i>
                                Try This
                            </a>
                        </div>
                    </div>
                </div>
                <div class="space">
                </div>
            </div>
        </div>
        <div class="col-xs-12 col-sm-6 col-lg-4">
            <div class="box">
                <div class="icon">
                    <div class="image">
                        <span class="fa fa-suitcase btn-lg white">
                        </span>
                    </div>
                    <div class="info">
                        <h3 class="title">
                            Employees
                        </h3>
                        <p>
                        </p>
                        <div class="more">
                            <a class="preview_a_r" target="_blank" href="{{ url('/template/employee-feedback/preview') }}" title="" id="Preview3">
                                <i class="fa fa-eye">
                                </i>
                                Preview
                            </a>
                            <a class="preview_a_l" href="{{ url('/template/employee-feedback/') }}" title="">
                                <i class="fa fa-external-link">
                                </i>
                                Try This
                            </a>
                        </div>
                    </div>
                </div>
                <div class="space">
                </div>
            </div>
        </div>
        <div class="col-xs-12 col-sm-6 col-lg-4">
            <div class="box">
                <div class="icon">
                    <div class="image">
                        <span class="fa fa-user btn-lg white">
                        </span>
                    </div>
                    <div class="info">
                        <h3 class="title">
                            Customers Satisfaction
                        </h3>
                        <p>
                        </p>
                        <div class="more">
                            <a class="preview_a_r" target="_blank" href="{{ url('/template/customer-satisfaction-feedback/preview') }}" id="Preview4" title="">
                                <i class="fa fa-eye">
                                </i>
                                Preview
                            </a>
                            <a class="preview_a_l" href="{{ url('/template/customer-satisfaction-feedback/') }}" title="">
                                <i class="fa fa-external-link">
                                </i>
                                Try This
                            </a>
                        </div>
                    </div>
                </div>
                <div class="space">
                </div>
            </div>
        </div>
        <div class="col-xs-12 col-sm-6 col-lg-4">
            <div class="box">
                <div class="icon">
                    <div class="image">
                        <span class="fa fa-calendar-o btn-lg white">
                        </span>
                    </div>
                    <div class="info">
                        <h3 class="title">
                            Event Planning
                        </h3>
                        <p>
                        </p>
                        <div class="more">
                            <a class="preview_a_r" target="_blank" href="{{ url('/template/event-planning-feedback/preview') }}" id="Preview5" title="">
                                <i class="fa fa-eye">
                                </i>
                                Preview
                            </a>
                            <a class="preview_a_l" href="{{ url('/template/event-planning-feedback/') }}" title="">
                                <i class="fa fa-external-link">
                                </i>
                                Try This
                            </a>
                        </div>
                    </div>
                </div>
                <div class="space">
                </div>
            </div>
        </div>
        <div class="col-xs-12 col-sm-6 col-lg-4">
            <div class="box">
                <div class="icon">
                    <div class="image">
                        <span class="fa fa-sellsy btn-lg white">
                        </span>
                    </div>
                    <div class="info">
                        <h3 class="title">
                            Market Research
                        </h3>
                        <p>
                        </p>
                        <div class="more">
                            <a class="preview_a_r" target="_blank" href="{{ url('/template/market-research-feedback/preview') }}" id="Preview6" title="">
                                <i class="fa fa-eye">
                                </i>
                                Preview
                            </a>
                            <a class="preview_a_l" href="{{ url('/template/market-research-feedback/') }}" title="">
                                <i class="fa fa-external-link">
                                </i>
                                Try This
                            </a>
                        </div>
                    </div>
                </div>
                <div class="space">
                </div>
            </div>
        </div>
    </div>
</div>
<!--break divider -->
<div class="break_divider">
</div>
<!--break divider -->
<div class="break_divider">
</div>
@endsection
