@extends('layouts.app')

@section('css')
    <link href="/assets/global/plugins/select2/select2.css" rel="stylesheet" type="text/css">
    <link href="/assets/admin/pages/css/login3.css" rel="stylesheet" type="text/css">
@endsection

@section('javascript')
    <script src="/assets/admin/pages/scripts/login.js" type="text/javascript"></script>
    <script>
        Login.init();
    </script>
@endsection

@section('content')
    <div class="page-content login">
        <div class="logo">
            Funds Request App
        </div>
        <div class="content">
            <!-- BEGIN LOGIN FORM -->
            <form class="login-form" action="{{ url('/login') }}" method="post" novalidate="novalidate">
                {!! csrf_field() !!}
                <h3 class="form-title">Login to your account</h3>
                <div class="alert alert-danger display-hide">
                    <button class="close" data-close="alert"></button>
                    <span>
                    Enter any username and password. </span>
                </div>
                <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                    <!--ie8, ie9 does not support html5 placeholder, so we just show field title for that-->
                    <label class="control-label visible-ie8 visible-ie9">Email Address</label>
                    <div class="input-icon">
                        <i class="fa fa-user"></i>
                        <input class="form-control placeholder-no-fix" type="text" autocomplete="off" placeholder="Email Address" name="email" value="{{ old('email') }}">
                    </div>
                    @if ($errors->has('email'))
                        <span class="help-block">
                            <strong>{{ $errors->first('email') }}</strong>
                        </span>
                    @endif
                </div>
                <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                    <label class="control-label visible-ie8 visible-ie9">Password</label>
                    <div class="input-icon">
                        <i class="fa fa-lock"></i>
                        <input class="form-control placeholder-no-fix" type="password" autocomplete="off" placeholder="Password" name="password">
                    </div>
                    @if ($errors->has('password'))
                        <span class="help-block">
                            <strong>{{ $errors->first('password') }}</strong>
                        </span>
                    @endif
                </div>
                <div class="form-actions">
                    <label class="checkbox">
                        <input type="checkbox" name="remember" value="1"/>
                        Remember me
                    </label>
                    <button type="submit" class="btn green-haze pull-right">
                    Login <i class="m-icon-swapright m-icon-white"></i>
                    </button>
                </div>
                <div class="forget-password">
                    <h4>Forgot your password ?</h4>
                    <p>
                         no worries, click <a href="{{ url('/password/reset') }}" id="forget-password">
                        here </a>
                        to reset your password.
                    </p>
                </div>
                <div class="create-account">
                    <p>
                         Don't have an account yet ?&nbsp; <a href="{{ url('/register') }}" id="register-btn">
                        Create an account </a>
                    </p>
                </div>
            </form>
            <!-- END LOGIN FORM -->
        </div>
    </div>
@endsection
