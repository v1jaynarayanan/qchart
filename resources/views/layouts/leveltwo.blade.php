<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1, user-scalable=no">

    <meta name="description" content="Use Feedback 360 to create fast and effective online surveys to gather a host of information regarding a particular subject. Signup for free account today." />
    <meta name="keywords" content="online surveys, free online survey, free online surveys, feedback, free online feedback, questionnaire, questionnaires, questionaire, questionaires" />
    <title>Feedback 360 | Create Free Online Survery | Free Online Survery Tool | Get Feedback online</title>

    <!-- favicon -->
    <link rel=icon href="../../images/favicon.png" sizes="16x16" type="image/png">
    <!-- Fonts -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css" integrity="sha384-XdYbMnZ/QjLh6iI4ogqCTaIjrFk87ip+ekIjefZch0Y+PvJ8CDYtEs1ipDmPorQ+" crossorigin="anonymous">
    <link href='https://fonts.googleapis.com/css?family=Yanone+Kaffeesatz:400,700|Open+Sans:400,600' rel='stylesheet' type='text/css'>

    <!-- Styles -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
    <link rel="stylesheet" href="../../css/style.css" />
    {{-- <link href="{{ elixir('../../css/app.css') }}" rel="stylesheet"> --}}

    <style>

        .fa-btn {
            margin-right: 6px;
        }
    </style>
</head>
<body class="body-sub" id="app-layout">
    @include('analyticstracking')
    <header class="sub-header">
            <div class="container">
                <div class="row">
                    <div class="col-md-3"><img src="../../images/logo.png" alt="James Saffron Logo" width="90" /></div>
                    <!-- Right Side Of Navbar -->
                    <div class="col-md-9">
                        <ul class="fR nav navbar-nav navbar-right">
                            <!-- Authentication Links -->
                            @if (Auth::guest())
                                <li><a href="{{ url('/login') }}">Login</a></li>
                                <li><a href="{{ url('/register') }}">Register</a></li>
                            @else
                                <li><a href="{{ url('/home') }}">My Surveys</a></li>
                                <li class="dropdown">
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                        {{ Auth::user()->name }} <span class="caret"></span>
                                    </a>

                                    <ul class="dropdown-menu" role="menu">
                                        <li><a href="{{ url('/logout') }}"><i class="fa fa-btn fa-sign-out"></i>Logout</a></li>
                                    </ul>
                                </li>
                            @endif
                        </ul>
                    </div>
                </div>
            </div>
    </header>
    @yield('content')

    <!-- JavaScripts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.3/jquery.min.js" integrity="sha384-I6F5OKECLVtK/BL+8iSLDEHowSAfUo76ZL9+kGAgTRdiByINKJaqTPH/QVNS1VDb" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
    {{-- <script src="{{ elixir('../../js/app.js') }}"></script> --}}
    <script src="../../js/spider.js"></script>   

    <!-- Go to www.addthis.com/dashboard to customize your tools -->
    <script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-57ffbb526238bb93"></script>
</body>
</html>
