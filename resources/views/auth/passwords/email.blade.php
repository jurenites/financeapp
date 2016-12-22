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
            <form class="forget-form" action="{{ url('/password/email') }}" method="post" novalidate="novalidate">
                {!! csrf_field() !!}
                <h3>Forget Password ?</h3>
                <p>
                     Enter your e-mail address below to reset your password.
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
                <div class="form-actions">
                    <a href="{{ url('/login') }}">
                        <button type="button" id="back-btn" class="btn">
                        <i class="m-icon-swapleft"></i> Back </button>
                    </a>
                    <button type="submit" class="btn green-haze pull-right">
                    Submit <i class="m-icon-swapright m-icon-white"></i>
                    </button>
                </div>
            </form>
            <!-- END FORGOT PASSWORD FORM -->
        </div>
    </div>
@endsection
