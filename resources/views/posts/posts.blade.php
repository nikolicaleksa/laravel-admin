@extends('layouts.authenticated')

@section('content')
    <div class="container">
        <div class="page-header">
            <h1 class="h2">@lang('content.posts.' . $type . '-posts-title')</h1>
            <span>@lang('content.posts.' . $type . '-posts-description')</span>
        </div>
        <div class="pull-left entries-categories">
            <ul id="posts-type-list" data-active-type="{{ $type }}">
                <li id="all-posts-href">
                    <a href="{{ route('showAllPostsList') }}" title="@lang('content.posts.all-posts-title')">
                        @lang('content.posts.all-posts-title') ({{ $postCounts['all'] }})
                    </a>
                </li>
                <li id="published-posts-href">
                    <a href="{{ route('showPublishedPostsList') }}" title="@lang('content.posts.published-posts-title')">
                        @lang('content.posts.published-posts-title') ({{ $postCounts['published'] }})
                    </a>
                </li>
                <li id="scheduled-posts-href">
                    <a href="{{ route('showScheduledPostsList') }}" title="@lang('content.posts.scheduled-posts-title')">
                        @lang('content.posts.scheduled-posts-title') ({{ $postCounts['scheduled'] }})
                    </a>
                </li>
                <li id="drafted-posts-href">
                    <a href="{{ route('showDraftedPostsList') }}" title="@lang('content.posts.drafted-posts-title')">
                        @lang('content.posts.drafted-posts-title') ({{ $postCounts['drafted'] }})
                    </a>
                </li>
                <li id="trashed-posts-href">
                    <a href="{{ route('showTrashedPostsList') }}" title="@lang('content.posts.trashed-posts-title')">
                        @lang('content.posts.trashed-posts-title') ({{ $postCounts['trashed'] }})
                    </a>
                </li>
            </ul>
            <div class="clearfix"></div>
        </div>
        <div class="text-right pull-right add-entry">
            <a class="btn btn-sm btn-success" href="{{ route('showAddPostForm') }}" title="@lang('content.posts.add-post-button')">
                <i class="fa fa-plus"></i> @lang('content.posts.add-post-button')
            </a>
        </div>
        <div class="clearfix"></div><br>
        @if(count($posts) > 0)
            <div class="table-responsive">
                <table class='table table-hover table-striped'>
                    <tr>
                        <th class="text-center">#</th>
                        <th class="text-center">@lang('content.posts.title')</th>
                        <th class="text-center">@lang('content.posts.category')</th>
                        <th class="text-center">@lang('content.posts.comments-count')</th>
                        <th class="text-center">@lang('content.posts.views')</th>
                        <th class="text-center">@lang('content.posts.status')</th>
                        <th class="text-center">@lang('content.table-headers.creation-date')</th>
                        <th class="text-center">@lang('content.table-headers.actions')</th>
                    </tr>
                    @foreach($posts as $key => $post)
                        <tr id="post-{{ $post->id }}-row" class="post-row text-center">
                            <td>@entryNo($key, $posts->currentPage(), $posts->perPage())</td>
                            <td>{{ $post->title}}</td>
                            <td>{{ $post->category->name }}</td>
                            <td>{{ $post->comments_count ?? 0 }}</td>
                            <td>{{ $post->views }}</td>
                            <td>
                                @if($post->trashed())
                                    @lang('content.posts.trashed')
                                @elseif($post->is_published)
                                    @if($post->isScheduled())
                                        @lang('content.posts.scheduled')
                                    @else
                                        @lang('content.posts.published')
                                    @endif
                                @else
                                    @lang('content.posts.drafted')
                                @endif
                            </td>
                            <td>{{ $post->created_at }}</td>
                            <td class="action-buttons">
                                <a data-toggle="tooltip" data-placement="top" class="btn btn-xs btn-primary" href="{{ route('showEditPostForm', ['post' => $post->id]) }}" title="@lang('content.posts.edit-post-button')">
                                    <i class="fa fa-pencil"></i>
                                </a>
                                @if($post->trashed())
                                    <a data-toggle="tooltip" data-placement="top" class="btn btn-xs btn-info restore" href="{{ route('restorePost', ['post' => $post->id]) }}" title="@lang('content.posts.restore-post-button')" data-message="@lang('messages.posts.restore-post', ['post' => htmlspecialchars($post->title)])">
                                        <i class="fa fa-undo"></i>
                                    </a>
                                @else
                                    <a data-toggle="tooltip" data-placement="top" class="btn btn-xs btn-danger delete" href="{{ route('deletePost', ['post' => $post->id]) }}" title="@lang('content.posts.delete-post-button')" data-message="@lang('messages.posts.delete-post', ['post' => htmlspecialchars($post->title)])">
                                        <i class="fa fa-trash"></i>
                                    </a>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </table>
            </div>
            <div class="text-center">
                <ul class="pagination">
                    {{ $posts->links() }}
                </ul>
            </div>
        @else
            <div class="alert alert-danger text-center" role="alert">
                <i class="fa fa-warning"></i> @lang('messages.posts.no-posts', ['type' => $noPostsKey])
            </div>
        @endif
    </div>
@endsection