<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
            <meta content="IE=edge" http-equiv="X-UA-Compatible">
                <meta content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
                    <meta content="Use Feedback 360 to create fast and effective online surveys to gather a host of information regarding a particular subject. Signup for free account today." name="description"/>
                    <meta content="online surveys, free online survey, free online surveys, feedback, free online feedback, questionnaire, questionnaires, questionaire, questionaires" name="keywords"/>
                    <title>
                        Feedback 360 | Create Free Online Survery | Free Online Survery Tool | Get Feedback online
                    </title>
                     <!-- Base Path -->
                    <base href="/" />
                    <!-- Fonts -->
                    <link crossorigin="anonymous" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css" integrity="sha384-XdYbMnZ/QjLh6iI4ogqCTaIjrFk87ip+ekIjefZch0Y+PvJ8CDYtEs1ipDmPorQ+" rel="stylesheet">
                        <link href="https://fonts.googleapis.com/css?family=Yanone+Kaffeesatz:400,700|Open+Sans:400,600" rel="stylesheet" type="text/css">
                            <!-- Styles -->
                            <link crossorigin="anonymous" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" rel="stylesheet">
                                <link href="css/style.css" rel="stylesheet"/>
                                {{--
                                <link href="{{ elixir('css/app.css') }}" rel="stylesheet">
                                    --}}
                                    <style>
                                        .fa-btn {
            margin-right: 6px;
        }
                                    </style>
                                </link>
                            </link>
                        </link>
                    </link>
                </meta>
            </meta>
        </meta>
    </head>
    <body class="body-sub" id="app-layout">
        @include('analyticstracking')
        <header class="sub-header">
            <div class="container">
                <div class="row">
                    <div class="col-md-3">
                        <img alt="James Saffron Logo" src="images/logo.png" width="100"/>
                    </div>
                    <!-- Right Side Of Navbar -->
                    <div class="col-md-9">
                        <ul class="fR nav navbar-nav navbar-right">
                            <!-- Authentication Links -->
                            @if (Auth::guest())
                            <li>
                                <a href="{{ url('/login') }}">
                                    Login
                                </a>
                            </li>
                            <li>
                                <a href="{{ url('/register') }}">
                                    Register
                                </a>
                            </li>
                            
                            @else
                            <li>
                                <a href="{{ url('/home') }}">
                                    My Surveys
                                </a>
                            </li>
                           
                            @endif
                            <li class="dropdown">
                                <a aria-expanded="false" class="dropdown-toggle" data-toggle="dropdown" href="#" role="button">
                                    Forms Category
                                    <span class="caret">
                                    </span>
                                </a>
                                <ul class="dropdown-menu" role="menu">
                                    <li>
                                        <a href="{{ url('/template/5000/') }}">
                                           
                                           Agile Sprint Retrospective Feedback
                                        </a>
                                    </li>
                                    <li>
                                        <a href="">
                                          
                                            Team Assessment Feedback
                                        </a>
                                    </li>
                                    <li>
                                        <a href="">
                                           
                                            Employee Feedback
                                        </a>
                                    </li>
                                    <li>
                                        <a href="">
                                            
                                            Customer Satisfaction Feedback
                                        </a>
                                    </li>
                                    <li>
                                        <a href="">
                                           
                                            Event Planning Feedback
                                        </a>
                                    </li>
                                    <li>
                                        <a href="">
                                          
                                            Market Research Feedback
                                        </a>
                                    </li>
                                </ul>
                            </li>
                              @if (!Auth::guest())
                             <li class="dropdown">
                                <a aria-expanded="false" class="dropdown-toggle" data-toggle="dropdown" href="#" role="button">
                                    {{ Auth::user()->name }}
                                    <span class="caret">
                                    </span>
                                </a>
                                <ul class="dropdown-menu" role="menu">
                                    <li>
                                        <a href="{{ url('/logout') }}">
                                            <i class="fa fa-btn fa-sign-out">
                                            </i>
                                            Logout
                                        </a>
                                    </li>
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
        <script crossorigin="anonymous" integrity="sha384-I6F5OKECLVtK/BL+8iSLDEHowSAfUo76ZL9+kGAgTRdiByINKJaqTPH/QVNS1VDb" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.3/jquery.min.js">
        </script>
        <script crossorigin="anonymous" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.6/js/bootstrap.min.js">
        </script>
        {{--
        <script src="{{ elixir('js/app.js') }}">
        </script>
        --}}
        <script src="js/spider.js">
        </script>
        <!-- Go to www.addthis.com/dashboard to customize your tools -->
        <script src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-57ffbb526238bb93" type="text/javascript">
        </script>
    </body>
</html>
