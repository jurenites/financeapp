@extends('layouts.app')

@section('css')
    <link href="/assets/global/plugins/select2/select2.css" rel="stylesheet" type="text/css">
    <link href="/assets/admin/pages/css/login3.css" rel="stylesheet" type="text/css">
@endsection

@section('javascript')
    <script src="/assets/admin/pages/scripts/login.js" type="text/javascript"></script>
    <script>
        Login.init();
        $(function () {
            $('.register-form').show();
        });
    </script>
@endsection

@section('content')
    <div class="page-content login">
        <div class="logo">
            Funds Request App
        </div>
        <div class="content">
            <!-- BEGIN REGISTRATION FORM -->
            <form class="register-form" action="{{ url('/register') }}" method="post" novalidate="novalidate">
                {!! csrf_field() !!}
                <h3>Sign Up</h3>
                <p>
                     Enter your personal details below:
                </p>
                <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                    <label class="control-label visible-ie8 visible-ie9">Full Name</label>
                    <div class="input-icon">
                        <i class="fa fa-font"></i>
                        <input class="form-control placeholder-no-fix" type="text" placeholder="Full Name" name="name"  value="{{ old('name') }}">
                    </div>
                    @if ($errors->has('name'))
                        <span class="help-block">
                            <strong>{{ $errors->first('name') }}</strong>
                        </span>
                    @endif
                </div>
                <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                    <!--ie8, ie9 does not support html5 placeholder, so we just show field title for that-->
                    <label class="control-label visible-ie8 visible-ie9">Email</label>
                    <div class="input-icon">
                        <i class="fa fa-envelope"></i>
                        <input class="form-control placeholder-no-fix" type="text" placeholder="Email" name="email"  value="{{ old('email') }}">
                    </div>
                    @if ($errors->has('email'))
                        <span class="help-block">
                            <strong>{{ $errors->first('email') }}</strong>
                        </span>
                    @endif
                </div>
                <div class="form-group{{ $errors->has('phone') ? ' has-error' : '' }}">
                    <!--ie8, ie9 does not support html5 placeholder, so we just show field title for that-->
                    <label class="control-label visible-ie8 visible-ie9">Phone</label>
                    <div class="input-icon">
                        <i class="fa fa-phone"></i>
                        <input class="form-control placeholder-no-fix" type="text" placeholder="Phone" name="phone"  value="{{ old('phone') }}">
                    </div>
                    @if ($errors->has('phone'))
                        <span class="help-block">
                            <strong>{{ $errors->first('phone') }}</strong>
                        </span>
                    @endif
                </div>
                <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                    <label class="control-label visible-ie8 visible-ie9">Password</label>
                    <div class="input-icon">
                        <i class="fa fa-lock"></i>
                        <input class="form-control placeholder-no-fix" type="password" autocomplete="off" id="register_password" placeholder="Password" name="password">
                    </div>
                    @if ($errors->has('password'))
                        <span class="help-block">
                            <strong>{{ $errors->first('password') }}</strong>
                        </span>
                    @endif
                </div>
                <div class="form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                    <label class="control-label visible-ie8 visible-ie9">Re-type Your Password</label>
                    <div class="controls">
                        <div class="input-icon">
                            <i class="fa fa-check"></i>
                            <input class="form-control placeholder-no-fix" type="password" autocomplete="off" placeholder="Re-type Your Password" name="password_confirmation">
                        </div>
                    </div>
                    @if ($errors->has('password_confirmation'))
                        <span class="help-block">
                            <strong>{{ $errors->first('password_confirmation') }}</strong>
                        </span>
                    @endif
                </div>
                <div class="form-actions">
                    <a href="{{ url('/login') }}">
                        <button id="register-back-btn" type="button" class="btn">
                        <i class="m-icon-swapleft"></i> Back to Login </button>
                    </a>
                    <button type="submit" id="register-submit-btn" class="btn green-haze pull-right">
                    Sign Up <i class="m-icon-swapright m-icon-white"></i>
                    </button>
                </div>
            </form>
            <!-- END REGISTRATION FORM -->
        </div>
    </div>
@endsection
