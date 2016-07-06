@extends('layouts.leveltwo')

@section('content')
    <div class="sub-page">
        <div id="loginContainer">
            <div id="loginBox">
                <h3>Reset Password</h3>
                <form class="form-horizontal" role="form" method="POST" action="{{ url('/password/reset') }}">
                    {{ csrf_field() }}

                    <input type="hidden" name="token" value="{{ $token }}">

                    <div class="group{{ $errors->has('email') ? ' has-error' : '' }}">
                        <input id="email" type="email" class="inputMaterial" name="email" value="{{ $email or old('email') }}" required>
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

                    <div class="group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                        <input id="password-confirm" type="password" class="inputMaterial" name="password_confirmation" required>
                        <span class="highlight"></span>
                        <span class="bar"></span>
                        <label for="password-confirm">Confirm Password</label>
                        @if ($errors->has('password_confirmation'))
                            <span class="help-block">
                                <strong>{{ $errors->first('password_confirmation') }}</strong>
                            </span>
                        @endif
                    </div>

                    <div class="group clearfix">
                        <button type="submit" class="btn fR">
                            <i class="fa fa-btn fa-refresh"></i> Reset Password
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection