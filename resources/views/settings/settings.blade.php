@extends('layouts.authenticated')

@section('content')
    <div class="container">
        <div class="page-header">
            <h1 class="h2">@lang('content.settings.' . $type . '-title')</h1>
            <span>@lang('content.settings.' . $type . '-description')</span>
        </div>
        <form id="settings-form" class="form-horizontal" method="POST" action="{{ route('updateSettings') }}" role="form" novalidate>
            @csrf
            <input type="hidden" name="type" value="{{ $type }}">
            @foreach($data as $key => $setting)
                <div class="form-group">
                    <label for="{{ $setting->name }}" class="col-xs-2 control-label">@lang('content.settings.' . $setting->name)</label>
                    <div id="{{ $setting->name }}_div" class="col-xs-10">
                        <input type="text" name="{{ $setting->name }}" id="{{ $setting->name }}" class="form-control" value="{{ $setting->value }}" placeholder="@lang('content.settings.' . $setting->name)" tabindex="{{ $key + 1 }}">
                        <p class="text-danger" id="{{ $setting->name }}_error"></p>
                    </div>
                </div>
            @endforeach
            <div class="form-group">
                <div class="col-sm-offset-2 col-xs-10">
                    <button type="submit" class="btn btn-success pull-right" tabindex="{{ $key + 2 }}">@lang('content.buttons.save')</button>
                </div>
            </div>
        </form>
    </div>
@endsection
