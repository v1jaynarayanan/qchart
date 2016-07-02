@extends('layouts.app')

@section('content')
<div class="sub-page">
    <div id="loginContainer">
        <div id="loginBox">
                <h3>Login</h3>
                    <form name="myForm" class="form-horizontal" id="loginForm" role="form" method="POST" action="{{ url('/login') }}">
                        {{ csrf_field() }}
                        <div class="group{{ $errors->has('email') ? ' has-error' : '' }}">
                            
                            <input id="email" type="email" class="inputMaterial" name="email" value="{{ old('email') }}" required>
                            <span class="highlight"></span>
                            <span class="bar"></span>
                            <label for="email">E-Mail Address</label>
                            @if ($errors->has('email'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('email') }}</strong>
                                </span>
                            @endif
                        </div>

                        <div class="group{{ $errors->has('password') ? ' has-error' : '' }}">
                            
                            <input id="password" type="password" class="inputMaterial" name="password" required>
                            <span class="highlight"></span>
                            <span class="bar"></span>
                            <label for="password">Password</label>
                            @if ($errors->has('password'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('password') }}</strong>
                                </span>
                            @endif
                        </div>
                        <!--    
                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="remember"> Remember Me
                                    </label>
                                </div>
                            </div>
                        </div>
                        -->
                        <div class="group clearfix">
                            <a class="fL" href="{{ url('/password/reset') }}">Forgot Your Password?</a>
                            <button type="submit" class="btn fR">
                                <i class="fa fa-btn fa-sign-in"></i> Login
                            </button>
                        </div>
                        <div class="newUser">Not a member?<a href="{{ url('/register') }}"> Register now</a></div>
                    </form>
        </div>
    </div>
</div>
@endsection
