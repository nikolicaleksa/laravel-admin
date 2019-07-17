@extends('layouts.guest')

@section('content')
    <div id="sign-in-box" class="col-lg-6 col-lg-offset-3 col-md-4 col-md-offset-4 col-sm-6 col-sm-offset-3 col-xs-10 col-xs-offset-1">
        <div class="panel panel-default col-md-10 col-md-offset-1 no-padding">
            <div class="panel-heading">
                <div class="panel-title">@lang('content.auth.sign-in-title')</div>
            </div>
            <div class="panel-body">
                <form id="sign-in-form" class="form-horizontal" method="POST" action="{{ route('signIn') }}" role="form" novalidate>
                    @csrf
                    <div class="form-group" id="username_div">
                        <div class="input-group">
                            <div class="input-group-addon"><i class="fa fa-fw fa-user"></i></div>
                            <input type="text" id="username" class="form-control" name="username" placeholder="@lang('content.auth.username')" tabindex="1" required autofocus >
                        </div>
                        <p class="text-danger" id="username_error"></p>
                    </div>
                    <div class="form-group" id="password_div">
                        <div class="input-group">
                            <div class="input-group-addon"><i class="fa fa-fw fa-lock"></i></div>
                            <input type="password" id="password" class="form-control" name="password" placeholder="@lang('content.auth.password')" tabindex="2" required>
                        </div>
                        <p class="text-danger" id="password_error"></p>
                    </div>
                    <div class="input-group">
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" name="remember_me" tabindex="3"> @lang('content.auth.remember-me')
                            </label>
                        </div>
                    </div>
                    <div class="form-group">
                        <div id="form-button">
                            <input type="submit" name="submit" class="btn btn-success btn-lg btn-block" value="@lang('content.auth.sign-in-button')" tabindex="4">
                        </div>
                    </div>
                </form>
                <div id="sign-in-response"></div>
            </div>
        </div>
    </div>
@endsection