@extends('layouts.authenticated')

@section('content')
    <div class="container">
        <div class="page-header">
            <h1 class="h2">@lang('content.media.add-media-title')</h1>
            <span>@lang('content.media.add-media-description')</span>
        </div>
        <form action="{{ route('addMedia') }}" class="dropzone" id="add-media-form">
            @csrf
            <div class="dz-message">
                <div class="drop-files">@lang('content.media.drop-files')</div>
                <div class="or"><small>@lang('content.media.or')</small></div>
                <div><button class="needsclick btn btn-default btn-lg">@lang('content.media.select-files')</button></div>
            </div>
        </form>
    </div>
@endsection
