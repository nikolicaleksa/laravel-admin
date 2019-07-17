@extends('layouts.authenticated')

@section('content')
    <div class="container">
        <div class="page-header">
            <h1 class="h2">@lang('content.categories.categories-title')</h1>
            <span>@lang('content.categories.categories-description')</span>
        </div>
        <div class="text-right add-entry">
            <a class="btn btn-sm btn-success" href="{{ route('showAddCategoryForm') }}" title="@lang('content.categories.add-category-button')">
                <i class="fa fa-plus"></i> @lang('content.categories.add-category-button')
            </a>
        </div>
        <div class="clearfix"></div><br>
        @if(count($categories))
            <div class="table-responsive">
                <table class='table table-hover table-striped'>
                    <tr>
                        <th class="text-center">#</th>
                        <th class="text-center">@lang('content.categories.name')</th>
                        <th class="text-center">@lang('content.categories.posts-count')</th>
                        <th class="text-center">@lang('content.table-headers.creation-date')</th>
                        <th class="text-center">@lang('content.table-headers.actions')</th>
                    </tr>

                    @foreach($categories as $key => $category)
                        <tr class="text-center">
                            <td>@entryNo($key, $categories->currentPage(), $categories->perPage())</td>
                            <td>{{ $category->name }}</td>
                            <td>{{ $category->posts_count }}</td>
                            <td>{{ $category->created_at }}</td>
                            <td class="action-buttons">
                                <a data-toggle="tooltip" data-placement="top" class="btn btn-xs btn-primary" href="{{ route('showEditCategoryForm', ['category' => $category->id]) }}" title="@lang('content.categories.edit-category-button')">
                                    <i class="fa fa-pencil"></i>
                                </a>
                                <a data-toggle="tooltip" data-placement="top" class="btn btn-xs btn-danger delete" href="{{ route('deleteCategory', ['category' => $category->id]) }}" title="@lang('content.categories.delete-category-button')" data-message="@lang('messages.categories.delete-category', ["category" => htmlspecialchars($category->name)])">
                                    <i class="fa fa-trash"></i>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </table>
            </div>
            <div class="text-center">
                <ul class="pagination">
                    {{ $categories->links() }}
                </ul>
            </div>
        @else
            <div class="alert alert-danger text-center" role="alert">
                <i class="fa fa-warning"></i> @lang('messages.categories.no-categories')
            </div>
        @endif
    </div>
@endsection