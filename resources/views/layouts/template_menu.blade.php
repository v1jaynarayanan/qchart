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
        <a aria-expanded="false" class="dropdown-toggle" data-toggle="dropdown" role="button">
            Templates
            <span class="caret">
            </span>
        </a>
        <ul class="dropdown-menu" role="menu">
            <li>
                <a href="{{ url('/template/agile-sprint-retrospective-feedback/') }}">
                    <i class="fa fa-btn fa-area-chart">
                    </i>
                    Agile Sprint Retrospective Feedback
                </a>
            </li>
            <li>
                <a href="{{ url('/template/team-assessment-feedback/') }}">
                    <i class="fa fa-btn fa-users">
                    </i>
                    Team Assessment Feedback
                </a>
            </li>
            <li>
                <a href="{{ url('/template/employee-feedback/') }}">
                    <i class="fa fa-btn fa-suitcase ">
                    </i>
                    Employee Feedback
                </a>
            </li>
            <li>
                <a href="{{ url('/template/customer-satisfaction-feedback/') }}">
                    <i class="fa fa-btn fa-user ">
                    </i>
                    Customer Satisfaction Feedback
                </a>
            </li>
            <li>
                <a href="{{ url('/template/event-planning-feedback/') }}">
                    <i class="fa fa-btn fa-calendar-o ">
                    </i>
                    Event Planning Feedback
                </a>
            </li>
            <li>
                <a href="{{ url('/template/market-research-feedback/') }}">
                    <i class="fa fa-btn fa-sellsy ">
                    </i>
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
