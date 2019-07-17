@extends('layouts.authenticated')

@section('content')
    <div class="container">
        <div class="page-header">
            <h1 class="h2">@lang('content.categories.add-category-title')</h1>
            <span>@lang('content.categories.add-category-description')</span>
        </div>
        <form id="edit-category-form" class="form-horizontal" method="POST" action="{{ route('updateCategory', ['category' => $category->id]) }}" role="form">
            @csrf
            <div class="form-group">
                <label for="name" class="col-xs-2 control-label">@lang('content.categories.name')</label>
                <div id="name_div" class="col-xs-10">
                    <input type="text" name="name" id="name" class="form-control" value="{{ $category->name }}" placeholder="@lang('content.categories.name')" tabindex="1">
                    <p id="name_error" class="text-danger"></p>
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-offset-2 col-xs-10">
                    <button type="submit" class="btn btn-success pull-right" tabindex="2">@lang('content.buttons.save')</button>
                </div>
            </div>
        </form>
    </div>
@endsection