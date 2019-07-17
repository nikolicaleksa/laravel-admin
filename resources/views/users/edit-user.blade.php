@extends('layouts.authenticated')

@section('content')
    <div class="container">
        <div class="page-header">
            <h1 class="h2">@lang('content.users.edit-user-title')</h1>
            <span>@lang('content.users.edit-user-description')</span>
        </div>
        <form id="edit-user-form" class="form-horizontal" method="POST" action="{{ route('updateUser', $user->id) }}" role="form">
            @csrf
            <div class="form-group">
                <label for="first_name" class="col-xs-2 control-label">@lang('content.users.first-name')</label>
                <div id="first_name_div" class="col-xs-10">
                    <input type="text" name="first_name" id="first_name" class="form-control" value="{{ $user->first_name }}" placeholder="@lang('content.users.first-name')" tabindex="1">
                    <p id="first_name_error" class="text-danger"></p>
                </div>
            </div>
            <div class="form-group">
                <label for="last_name" class="col-xs-2 control-label">@lang('content.users.last-name')</label>
                <div id="last_name_div" class="col-xs-10">
                    <input type="text" name="last_name" id="last_name" class="form-control" value="{{ $user->last_name }}" placeholder="@lang('content.users.last-name')" tabindex="2">
                    <p id="last_name_error" class="text-danger"></p>
                </div>
            </div>
            <div class="form-group">
                <label for="username" class="col-xs-2 control-label">@lang('content.users.username')</label>
                <div id="username_div" class="col-xs-10">
                    <input type="text" name="username" id="username" class="form-control" value="{{ $user->username }}" placeholder="@lang('content.users.username')" tabindex="3">
                    <p id="username_error" class="text-danger"></p>
                </div>
            </div>
            <div class="form-group">
                <label for="password" class="col-xs-2 control-label">@lang('content.users.password')</label>
                <div id="password_div" class="col-xs-10">
                    <input type="password" name="password" id="password" class="form-control" placeholder="@lang('content.users.password')" tabindex="4">
                    <p id="password_error" class="text-danger"></p>
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-offset-2 col-xs-10">
                    <button type="submit" class="btn btn-success pull-right" tabindex="5">@lang('content.buttons.save')</button>
                </div>
            </div>
        </form>
    </div>
@endsection