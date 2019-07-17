@extends('layouts.authenticated')

@section('content')
    <div class="container">
        <div class="page-header">
            <h1 class="h2">@lang('content.comments.approved-comments-title')</h1>
            <span>@lang('content.comments.approved-comments-description')</span>
        </div>
        <div class="text-right add-entry">
            <a class="btn btn-sm btn-success" href="{{ route('showUnapprovedCommentsList') }}" title="@lang('content.comments.unapproved-comments-button')">
                <i class="fa fa-comments"></i> @lang('content.comments.unapproved-comments-button')
            </a>
        </div>
        <div class="clearfix"></div><br>

        @if(count($comments) > 0)
            <div class="table-responsive">
                <table class='table table-hover table-striped'>
                    <tr>
                        <th class="text-center">#</th>
                        <th class="text-center">@lang('content.comments.name')</th>
                        <th class="text-center">@lang('content.comments.short-preview')</th>
                        <th class="text-center">@lang('content.comments.post-title')</th>
                        <th class="text-center">@lang('content.table-headers.creation-date')</th>
                        <th class="text-center">@lang('content.table-headers.actions')</th>
                    </tr>

                    @foreach($comments as $key => $comment)
                        <div id="comment-{{ $comment->id }}-modal" class="modal fade" tabindex="-1" role="dialog">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content text-left">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="@lang('content.buttons.close')">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                        <h4 class="modal-title">@lang('content.comments.comment-preview')</h4>
                                    </div>
                                    <div class="modal-body comment-body">
                                        <p>{{ $comment->content }}</p>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-warning unapprove-comment" data-comment-id="{{ $comment->id }}" data-unapprove-url="{{ route('unapproveComment', ['comment' => $comment->id]) }}">
                                            @lang('content.comments.unapprove-comment-button')
                                        </button>
                                        <button type="button" class="btn btn-default" data-dismiss="modal">
                                            @lang('content.buttons.close')
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <tr id="comment-{{ $comment->id }}-row" class="comment-row text-center">
                            <td>@entryNo($key, $comments->currentPage(), $comments->perPage())</td>
                            <td>{{ $comment->name }}</td>
                            <td>{{ $comment->content_short }}</td>
                            <td>
                                @if(is_null($comment->post_link))
                                    @lang('messages.posts.post-not-found')
                                @else
                                    <a href="{{ $comment->post_link }}" title="{{ $comment->post->title }}">{{ $comment->post->title }}</a>
                                @endif
                            </td>
                            <td>{{ $comment->created_at }}</td>
                            <td class="action-buttons">
                            <span data-toggle="tooltip" data-placement="top" title="@lang('content.comments.view-comment-button')">
                                <button data-toggle="modal" data-target="#comment-{{ $comment->id }}-modal" class="btn btn-xs btn-warning">
                                    <i class="fa fa-search"></i>
                                </button>
                            </span>
                                <a data-toggle="tooltip" data-placement="top" class="btn btn-xs btn-danger delete" href="{{ route('deleteComment', ['comment' => $comment->id]) }}" title="@lang('content.comments.delete-comment-button')" data-message="@lang('messages.comments.delete-comment', ['name' => htmlspecialchars($comment->name)])">
                                    <i class="fa fa-trash"></i>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </table>
            </div>
            <div class="text-center">
                <ul class="pagination">
                    {{ $comments->links() }}
                </ul>
            </div>
        @else
            <div class="alert alert-danger text-center" role="alert">
                <i class="fa fa-warning"></i> @lang('messages.comments.no-approved-comments')
            </div>
        @endif
    </div>
@endsection