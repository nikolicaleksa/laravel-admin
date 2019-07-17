<?php

namespace App\Http\Controllers;

use App\Comment;
use App\Post;
use Exception;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Str;
use Illuminate\View\View;

class CommentController extends Controller
{
    private const COMMENTS_PER_PAGE = 15;


    /**
     * CommentController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('ajax')->only(['approveComment', 'unApproveComment']);
    }

    /**
     * Display list of comments waiting for approval.
     *
     * @return View
     */
    public function showUnapprovedCommentsList(): View
    {
        $comments = $this->getCommentsPagination(false);

        return view('comments/unapproved-comments', [
            'comments' => $comments,
        ]);
    }

    /**
     * Display list of approved comments.
     *
     * @return View
     */
    public function showApprovedCommentsList(): View
    {
        $comments = $this->getCommentsPagination(true);

        return view('comments/approved-comments', [
            'comments' => $comments
        ]);
    }


    /**
     * Approve comment.
     *
     * @param Comment $comment
     *
     * @return JsonResponse
     */
    public function approveComment(Comment $comment): JsonResponse
    {
        $comment->update([
            'is_approved' => true
        ]);

        return response()->json([
            'code' => JsonResponse::HTTP_OK,
            'response' => trans('messages.comments.comment-approved'),
        ]);
    }

    /**
     * Unapprove comment.
     *
     * @param Comment $comment
     *
     * @return JsonResponse
     */
    public function unapproveComment(Comment $comment): JsonResponse
    {
        $comment->update([
            'is_approved' => false
        ]);

        return response()->json([
            'code' => JsonResponse::HTTP_OK,
            'response' => trans('messages.comments.comment-unapproved'),
        ]);
    }

    /**
     * Delete comment.
     *
     * @param Comment $comment
     *
     * @return JsonResponse
     */
    public function deleteComment(Comment $comment): JsonResponse
    {
        try {
            $comment->delete();
        } catch (Exception $e) {
            return response()->json([
                'code' => JsonResponse::HTTP_INTERNAL_SERVER_ERROR,
                'response' => trans('messages.failure.unknown-error'),
            ]);
        }

        return response()->json([
            'code' => JsonResponse::HTTP_OK,
            'response' => trans('messages.comments.comment-deleted'),
        ]);
    }

    /**
     * Get comments pagination for display.
     *
     * @param bool $approved
     *
     * @return LengthAwarePaginator
     */
    private function getCommentsPagination(bool $approved): LengthAwarePaginator
    {
        $comments = Comment::with(['post'])
            ->where('is_approved', $approved)
            ->latest()
            ->paginate(self::COMMENTS_PER_PAGE);

        foreach ($comments as $comment) {
            $comment->content_short = $this->generateShortContent($comment->content);
            $comment->post_link = $this->generatePostUrl($comment->post);
        }

        return $comments;
    }

    /**
     * Generate short content for a comment.
     *
     * @param string $content
     * @param int $length
     *
     * @return string
     */
    private function generateShortContent(string $content, int $length = 50): string
    {
        if (Str::length($content) > $length) {
            return Str::substr($content, 0, 50) . '…';
        }

        return $content;
    }

    /**
     * Generate post url.
     *
     * @param Post|null $post
     *
     * @return string|null
     */
    private function generatePostUrl(?Post $post): ?string
    {
        if (!is_null($post)) {
            return route('showEditPostForm', [
                'post' => $post->id
            ]);
        }

        return null;
    }
}
