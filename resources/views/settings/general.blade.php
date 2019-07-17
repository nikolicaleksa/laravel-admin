@extends('layouts.authenticated')

@section('content')
    <div class="container">
        <div class="page-header">
            <h1 class="h2">@lang('content.settings.general-title')</h1>
            <span>@lang('content.settings.general-description')</span>
        </div>
        <form id="settings-form" class="form-horizontal" method="POST" action="{{ route('updateSettings') }}" enctype="multipart/form-data" role="form" novalidate>
            @csrf
            <input type="hidden" name="type" value="{{ $settingsData['type'] }}">
            <div class="form-group">
                <label for="title" class="col-xs-2 control-label">@lang('content.settings.title')</label>
                <div id="title_div" class="col-xs-10">
                    <input type="text" name="title" id="title" class="form-control" value="{{ $settingsData['title'] }}" placeholder="@lang('content.settings.title')" tabindex="1">
                    <p class="text-danger" id="title_error"></p>
                </div>
            </div>
            <div class="form-group">
                <label for="title_short" class="col-xs-2 control-label">@lang('content.settings.title-short')</label>
                <div id="title_short_div" class="col-xs-10">
                    <input type="text" name="title_short" id="title_short" class="form-control" value="{{ $settingsData['title_short'] }}" placeholder="@lang('content.settings.title-short')" tabindex="2">
                    <p class="text-danger" id="title_short_error"></p>
                </div>
            </div>
            <div class="form-group">
                <label for="description" class="col-xs-2 control-label">@lang('content.settings.description')</label>
                <div id="description_div" class="col-xs-10">
                    <input type="text" name="description" id="description" class="form-control" value="{{ $settingsData['description'] }}" placeholder="@lang('content.settings.description')" tabindex="3">
                    <p class="text-danger" id="description_error"></p>
                </div>
            </div>
            <div class="form-group">
                <label for="keywords" class="col-xs-2 control-label">@lang('content.settings.keywords')</label>
                <div id="keywords_div" class="col-xs-10">
                    <input type="text" name="keywords" id="keywords" class="form-control tagsinput" value="{{ $settingsData['keywords'] }}" tabindex="4">
                    <p class="text-danger" id="keywords_error"></p>
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