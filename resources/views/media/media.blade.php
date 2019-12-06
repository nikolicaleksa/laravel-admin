@extends('layouts.authenticated')

@section('content')
    <div class="container">
        <div class="page-header">
            <h1 class="h2">@lang('content.media.media-title')</h1>
            <span>@lang('content.media.media-description')</span>
        </div>
        <div class="text-right pull-right add-entry">
            <a class="btn btn-sm btn-success" href="{{ route('showAddMediaForm') }}" title="@lang('content.media.add-media-button')">
                <i class="fa fa-plus"></i> @lang('content.media.add-media-button')
            </a>
            <a class="btn btn-sm btn-danger delete-medias" href="{{ route('deleteMedia') }}" title="@lang('content.media.delete-selected-media-button')" data-message="@lang('messages.media.delete-media')">
                <i class="fa fa-remove"></i> @lang('content.media.delete-selected-media-button')
            </a>
            @csrf
        </div>
        <div class="clearfix"></div><br>
        @if(count($medias) > 0)
            <ul class="row" id="media-list">
                @foreach($medias as $media)
                    <li class="col-lg-1 col-md-2 col-sm-3" tabindex="0" role="checkbox" aria-label="{{ $media->name }}" aria-checked="false" data-id="{{ $media->id }}" class="attachment save-ready">
                        <div class="media-item">
                            <div class="media-thumbnail">
                                <div class="media-centered">
                                    <img src="@media($media, 'thumbnail')" draggable="false" alt="{{ $media->name }}">
                                </div>
                            </div>
                        </div>
                        <button type="button" class="check" tabindex="-1">
                            <span class="fa fa-check-square"></span>
                        </button>
                    </li>
                @endforeach
            </ul>
            <div class="text-center">
                <ul class="pagination">
                    {{ $medias->links() }}
                </ul>
            </div>
        @else
            <div class="alert alert-danger text-center" role="alert">
                <i class="fa fa-warning"></i> @lang('messages.media.no-media')
            </div>
        @endif
    </div>
@endsection
