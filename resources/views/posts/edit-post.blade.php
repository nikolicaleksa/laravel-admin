@extends('layouts.authenticated')

@section('content')
    <div class="container">
        <div class="page-header">
            <h1 class="h2">@lang('content.posts.add-post-title')</h1>
            <span>@lang('content.posts.add-post-description')</span>
        </div>
        <form id="edit-post-form" class="form-horizontal" method="POST" action="{{ route('updatePost', ['post' => $post->id]) }}" role="form">
            @csrf
            <div class="form-group">
                <label for="title" class="col-xs-2 control-label">@lang('content.posts.title')</label>
                <div id="title_div" class="col-xs-10">
                    <input type="text" name="title" id="title" class="form-control" value={{ $post->title }}" placeholder="@lang('content.posts.title')" tabindex="1">
                    <p id="title_error" class="text-danger"></p>
                </div>
            </div>
            <div class="form-group">
                <label for="description" class="col-xs-2 control-label">@lang('content.posts.description')</label>
                <div id="description_div" class="col-xs-10">
                    <input type="text" name="description" id="description" class="form-control" value={{ $post->description }}" placeholder="@lang('content.posts.description')" tabindex="2">
                    <p id="description_error" class="text-danger"></p>
                </div>
            </div>
            <div class="form-group">
                <label for="keywords" class="col-xs-2 control-label">@lang('content.posts.keywords')</label>
                <div id="keywords_div" class="col-xs-10">
                    <input type="text" name="keywords" id="keywords" class="form-control tagsinput" value={{ $post->keywords }}" tabindex="3">
                    <p id="keywords_error" class="text-danger"></p>
                </div>
            </div>
            <div class="form-group">
                <label for="content" class="col-xs-2 control-label">@lang('content.posts.content')</label>
                <div id="content_div" class="col-xs-10">
                    <textarea name="content" id="content" class="form-control editor" placeholder="@lang('content.posts.content')" tabindex="4">
                        {{ $post->content }}
                    </textarea>
                    <p id="content_error" class="text-danger"></p>
                </div>
            </div>
            <div class="form-group">
                <label for="image" class="col-xs-2 control-label">@lang('content.posts.image')</label>
                <div id="image_div" class="col-xs-10">
                    <input type="file" name="image" id="image" class="form-control" tabindex="5">
                    <p id="image_error" class="text-danger"></p>
                </div>
            </div>
            <div class="form-group">
                <label for="category_id" class="col-xs-2 control-label">@lang('content.posts.category')</label>
                <div id="category_id_div" class="col-xs-10">
                    <select name="category_id" class="form-control" id="category_id" tabindex="6" data-selected="{{ $post->category_id }}">
                        <option selected disabled value="">@lang('content.posts.select-category')</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                    <p id="category_id_error" class="text-danger"></p>
                </div>
            </div>
            <div class="form-group">
                <label for="publish_option" class="col-xs-2 control-label">@lang('content.posts.publish-options')</label>
                <div id="publish_options_div" class="col-xs-10">
                    <select name="publish_option" class="form-control" id="publish_option" tabindex="7" data-selected="{{ $post->getPublishOption() }}">
                        <option selected disabled value="">@lang('content.posts.publish-options-list.select-option')</option>
                        @foreach($publishOptions as $publishOption)
                            <option value="{{ $publishOption }}">@lang('content.posts.publish-options-list.' . $publishOption)</option>
                        @endforeach
                    </select>
                    <p id="publish_options_error" class="text-danger"></p>
                </div>
            </div>
            <div id="published_at_parent" class="form-group @if(!$post->isScheduled()) hidden @endif">
                <label for="published_at" class="col-xs-2 control-label">@lang('content.posts.publish-at')</label>
                <div id="published_at_div" class="col-xs-10">
                    <input type="text" name="publish_at" id="published_at" class="form-control" value="{{ $post->published_at }}" readonly tabindex="8">
                    <p id="published_at_error" class="text-danger"></p>
                </div>
            </div>
            <div class="form-group">
                <div class="col-xs-offset-2 col-xs-10">
                    <button type="submit" class="btn btn-success pull-right" tabindex="9">@lang('content.buttons.save')</button>
                </div>
            </div>
        </form>
    </div>
@endsection