@extends('layouts.inner')

@section('content')
    <div class="sub-page">
        <div id="loginContainer">
            <div id="loginBox">
                <h3>Reset Password</h3>
                @if (session('status'))
                    <div class="alert alert-success">
                        {{ session('status') }}
                    </div>
                @endif

                <form class="form-horizontal" role="form" method="POST" action="{{ url('/password/email') }}">
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

                    <div class="group clearfix">
                        <button type="submit" class="btn fR">
                            <i class="fa fa-btn fa-envelope"></i> Send Password Reset Link
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection