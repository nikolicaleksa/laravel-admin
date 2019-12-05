@extends('layouts.authenticated')

@section('content')
    <div class="container">
        <div class="page-header">
            <h1 class="h2">@lang('content.posts.add-post-title')</h1>
            <span>@lang('content.posts.add-post-description')</span>
        </div>
        <form id="add-post-form" class="form-horizontal" method="POST" action="{{ route('addPost') }}" role="form">
            <div class="row">
                <div class="col-lg-9 col-sm-12">
                    @csrf
                    <div class="form-group">
                        <label for="title" class="col-xs-1 control-label">@lang('content.posts.title')</label>
                        <div id="title_div" class="col-xs-11">
                            <input type="text" name="title" id="title" class="form-control" placeholder="@lang('content.posts.title')" tabindex="1">
                            <p id="title_error" class="text-danger"></p>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="content" class="col-xs-1 control-label">@lang('content.posts.content')</label>
                        <div id="content_div" class="col-xs-11">
                            <textarea name="content" id="content" class="form-control editor" placeholder="@lang('content.posts.content')" tabindex="2"></textarea>
                            <p id="content_error" class="text-danger"></p>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-xs-offset-1 col-xs-11">
                            <button type="submit" class="btn btn-success pull-right" tabindex="9">@lang('content.buttons.save')</button>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-12">
                    <div class="col-sm-12">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3 class="panel-title">@lang("content.posts.general")</h3>
                            </div>
                            <div class="panel-body post-data">
                                <div class="form-group">
                                    <div class="col-sm-12 text-left">
                                        <label for="description" class="control-label">@lang('content.posts.description')</label>
                                    </div>
                                    <div id="description_div" class="col-xs-12">
                                        <textarea name="description" id="description" class="form-control" placeholder="@lang('content.posts.description')" tabindex="3" rows="5"></textarea>
                                        <p id="description_error" class="text-danger"></p>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-sm-12 text-left">
                                        <label for="keywords" class="control-label">@lang('content.posts.keywords')</label>
                                    </div>
                                    <div id="keywords_div" class="col-xs-12">
                                        <input type="text" name="keywords" id="keywords" class="form-control tagsinput" tabindex="4">
                                        <p id="keywords_error" class="text-danger"></p>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-sm-12 text-left">
                                        <label for="category_id" class="control-label">@lang('content.posts.category')</label>
                                    </div>
                                    <div id="category_id_div" class="col-xs-12">
                                        <select name="category_id" class="form-control" id="category_id" tabindex="5">
                                            <option selected disabled value="">@lang('content.posts.select-category')</option>
                                            @foreach($categories as $category)
                                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                                            @endforeach
                                        </select>
                                        <p id="category_id_error" class="text-danger"></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3 class="panel-title">@lang('content.posts.image')</h3>
                            </div>
                            <div class="panel-body">
                                <div class="form-group">
                                    <div class="col-sm-12 text-left">
                                        <label for="image" class="control-label">@lang('content.posts.image')</label>
                                    </div>
                                    <div id="image_div" class="col-xs-12">
                                        <input type="hidden" name="image" id="image" class="form-control">
                                        <button type="button" class="btn btn-default" tabindex="6">Select image</button>
                                        <p id="image_error" class="text-danger"></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3 class="panel-title">@lang('content.posts.publish-options')</h3>
                            </div>
                            <div class="panel-body">
                                <div class="form-group">
                                    <div class="col-xs-12 text-left">
                                        <label for="publish_option" class="control-label">@lang('content.posts.publish-options')</label>
                                    </div>
                                    <div id="publish_option_div" class="col-xs-12">
                                        <select name="publish_option" class="form-control" id="publish_option" tabindex="7">
                                            <option selected disabled value="">@lang('content.posts.publish-options-list.select-option')</option>
                                            @foreach($publishOptions as $publishOption)
                                                <option value="{{ $publishOption }}">@lang('content.posts.publish-options-list.' . $publishOption)</option>
                                            @endforeach
                                        </select>
                                        <p id="publish_option_error" class="text-danger"></p>
                                    </div>
                                </div>
                                <div id="published_at_parent" class="form-group hidden">
                                    <div class="col-xs-12 text-left">
                                        <label for="published_at" class="control-label">@lang('content.posts.publish-at')</label>
                                    </div>
                                    <div id="published_at_div" class="col-xs-12">
                                        <input type="text" name="published_at" id="published_at" class="form-control" readonly tabindex="8">
                                        <p id="published_at_error" class="text-danger"></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection
