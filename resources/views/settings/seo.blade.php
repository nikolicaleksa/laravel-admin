@extends('layouts.authenticated')

@section('content')
    <div class="container">
        <div class="page-header">
            <h1 class="h2">@lang('content.settings.seo-title')</h1>
            <span>@lang('content.settings.seo-description')</span>
        </div>
        <form id="settings-form" class="form-horizontal" method="POST" action="{{ route('updateSettings') }}" enctype="multipart/form-data" role="form" novalidate>
            @csrf
            <input type="hidden" name="type" value="{{ $settingsData['type'] }}">
            <div class="form-group">
                <label for="google_verification_code" class="col-xs-2 control-label">@lang('content.settings.google_verification_code')</label>
                <div id="google_verification_code_div" class="col-xs-10">
                    <input type="text" name="google_verification_code" id="google_verification_code" class="form-control" value="{{ $settingsData['google_verification_code'] }}" placeholder="@lang('content.settings.google_verification_code')" tabindex="1">
                    <p class="text-danger" id="google_verification_code_error"></p>
                </div>
            </div>
            <div class="form-group">
                <label for="bing_verification_code" class="col-xs-2 control-label">@lang('content.settings.bing_verification_code')</label>
                <div id="bing_verification_code_div" class="col-xs-10">
                    <input type="text" name="bing_verification_code" id="bing_verification_code" class="form-control" value="{{ $settingsData['bing_verification_code'] }}" placeholder="@lang('content.settings.bing_verification_code')" tabindex="2">
                    <p class="text-danger" id="bing_verification_code_error"></p>
                </div>
            </div>
            <div class="form-group">
                <label for="yandex_verification_code" class="col-xs-2 control-label">@lang('content.settings.yandex_verification_code')</label>
                <div id="yandex_verification_code_div" class="col-xs-10">
                    <input type="text" name="yandex_verification_code" id="yandex_verification_code" class="form-control" value="{{ $settingsData['yandex_verification_code'] }}" placeholder="@lang('content.settings.yandex_verification_code')" tabindex="3">
                    <p class="text-danger" id="yandex_verification_code_error"></p>
                </div>
            </div>
            <div class="form-group">
                <label for="google_analytics" class="col-xs-2 control-label">@lang('content.settings.google_analytics')</label>
                <div id="google_analytics_div" class="col-xs-10">
                    <input type="text" name="google_analytics" id="google_analytics" class="form-control" value="{{ $settingsData['google_analytics'] }}" placeholder="@lang('content.settings.google_analytics')" tabindex="4">
                    <p class="text-danger" id="google_analytics_error"></p>
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