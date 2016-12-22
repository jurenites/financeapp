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
            $('.forget-form').show();
        });
    </script>
@endsection

@section('content')
    <div class="page-content login">
        <div class="logo">
            Funds Request App
        </div>
        <div class="content">
            <!-- BEGIN FORGOT PASSWORD FORM -->
            <form class="forget-form" action="{{ url('/password/reset') }}" method="post" novalidate="novalidate">
                {!! csrf_field() !!}
                <input type="hidden" name="token" value="{{ $token }}">
                <h3>Change password</h3>
                <p>
                     Enter your e-mail address and new password.
                </p>
                <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                    <div class="input-icon">
                        <i class="fa fa-envelope"></i>
                        <input class="form-control placeholder-no-fix" type="text" autocomplete="off" placeholder="Email" name="email">
                    </div>
                    @if ($errors->has('email'))
                        <span class="help-block">
                            <strong>{{ $errors->first('email') }}</strong>
                        </span>
                    @endif
                </div>
                <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                    <div class="input-icon">
                        <i class="fa fa-envelope"></i>
                        <input class="form-control placeholder-no-fix" type="password" autocomplete="off" placeholder="New Password" name="password">
                    </div>
                    @if ($errors->has('password'))
                        <span class="help-block">
                            <strong>{{ $errors->first('password') }}</strong>
                        </span>
                    @endif
                </div>
                <div class="form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                    <div class="input-icon">
                        <i class="fa fa-envelope"></i>
                        <input class="form-control placeholder-no-fix" type="password" autocomplete="off" placeholder="Confirm Password" name="password_confirmation">
                    </div>
                    @if ($errors->has('password_confirmation'))
                        <span class="help-block">
                            <strong>{{ $errors->first('password_confirmation') }}</strong>
                        </span>
                    @endif
                </div>
                <div class="form-actions">
                    <a href="{{ url('/login') }}">
                        <button type="button" id="back-btn" class="btn">
                        <i class="m-icon-swapleft"></i> Back </button>
                    </a>
                    <button type="submit" class="btn green-haze pull-right">
                    Change password <i class="m-icon-swapright m-icon-white"></i>
                    </button>
                </div>
            </form>
            <!-- END FORGOT PASSWORD FORM -->
        </div>
    </div>
@endsection