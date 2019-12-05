<?php

namespace App\Http\Controllers;

use App\Category;
use App\Http\Requests\SavePostRequest;
use App\Post;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;

class PostController extends Controller
{
    private const POSTS_PER_PAGE = 15;


    /**
     * PostController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('ajax')->only(['deletePost', 'restorePost', 'addPost', 'updatePost']);
    }

    /**
     * Display a list of all posts.
     *
     * @return View
     */
    public function showAllPostsList(): View
    {
        $posts = Post::with(['category', 'author'])
            ->withCount(['comments'])
            ->latest()
            ->paginate(self::POSTS_PER_PAGE);

        return view('posts/posts', [
            'posts' => $posts,
            'postCounts' => Post::counts(),
            'type' => 'all',
            'noPostsKey' => '',
        ]);
    }

    /**
     * Display a list of published posts.
     *
     * @return View
     */
    public function showPublishedPostsList(): View
    {
        $posts = Post::with(['category', 'author'])
            ->withCount(['comments'])
            ->where('is_published', true)
            ->where('published_at', '<=', Carbon::now())
            ->latest()
            ->paginate(self::POSTS_PER_PAGE);

        return view('posts/posts', [
            'posts' => $posts,
            'postCounts' => Post::counts(),
            'type' => 'published',
            'noPostsKey' => 'published',
        ]);
    }

    /**
     * Display a list of scheduled posts.
     *
     * @return View
     */
    public function showScheduledPostsList(): View
    {
        $posts = Post::with(['category', 'author'])
            ->withCount(['comments'])
            ->where('is_published', true)
            ->where('published_at', '>', Carbon::now())
            ->latest()
            ->paginate(self::POSTS_PER_PAGE);

        return view('posts/posts', [
            'posts' => $posts,
            'postCounts' => Post::counts(),
            'type' => 'scheduled',
            'noPostsKey' => 'scheduled',
        ]);
    }

    /**
     * Display a list of drafted posts.
     *
     * @return View
     */
    public function showDraftedPostsList(): View
    {
        $posts = Post::with(['category', 'author'])
            ->withCount(['comments'])
            ->where('is_published', false)
            ->latest()
            ->paginate(self::POSTS_PER_PAGE);

        return view('posts/posts', [
            'posts' => $posts,
            'postCounts' => Post::counts(),
            'type' => 'drafted',
            'noPostsKey' => 'drafted',
        ]);
    }

    /**
     * Display a list of trashed posts.
     *
     * @return View
     */
    public function showTrashedPostsList(): View
    {
        $posts = Post::with(['category', 'author'])->onlyTrashed()->latest()->paginate(self::POSTS_PER_PAGE);

        return view('posts/posts', [
            'posts' => $posts,
            'postCounts' => Post::counts(),
            'type' => 'trashed',
            'noPostsKey' => 'trashed',
        ]);
    }

    /**
     * Display add post form.
     *
     * @return View
     */
    public function showAddPostForm(): View
    {
        $categories = Category::select(['id', 'name'])->get();

        return view('posts/add-post', [
            'categories' => $categories,
            'publishOptions' => Post::PUBLISH_OPTIONS,
        ]);
    }

    /**
     * Display edit post form.
     *
     * @param int $post
     *
     * @return View
     */
    public function showEditPostForm($post): View
    {
        $post = Post::withTrashed()->find($post);

        if (null !== $post) {
            $categories = Category::all();

            return view('posts/edit-post', [
                'post' => $post,
                'categories' => $categories,
                'publishOptions' => Post::PUBLISH_OPTIONS,
            ]);
        }

        abort(404);
    }

    /**
     * Move post to trash.
     *
     * @param Post $post
     *
     * @return JsonResponse
     */
    public function deletePost(Post $post): JsonResponse
    {
        try {
            $post->delete();
        } catch (Exception $ex) {
            return response()->json([
                'code' => JsonResponse::HTTP_INTERNAL_SERVER_ERROR,
                'response' => trans('messages.failure.unknown-error')
            ]);
        }

        return response()->json([
            'code' => JsonResponse::HTTP_OK,
            'response' => trans('messages.posts.post-deleted')
        ]);
    }

    /**
     * Restore post from trash.
     *
     * @param int $post
     *
     * @return JsonResponse
     */
    public function restorePost($post): JsonResponse
    {
        $post = Post::onlyTrashed()->find($post);

        if (null !== $post) {
            $post->restore();

            return response()->json([
                'code' => JsonResponse::HTTP_OK,
                'response' => trans('messages.posts.post-restored')
            ]);
        }

        abort(404);
    }

    /**
     * Add new post.
     *
     * @param SavePostRequest $request
     *
     * @return JsonResponse
     */
    public function addPost(SavePostRequest $request): JsonResponse
    {
        $publishedAt = null;
        $isPublished = true;
        $publishOption = $request->get('publish_option');

        if ($publishOption == Post::PUBLISH_OPTIONS['now']) {
            $publishedAt = Carbon::now();
        } elseif ($publishOption == Post::PUBLISH_OPTIONS['draft']) {
            $isPublished = false;
        } elseif ($publishOption == Post::PUBLISH_OPTIONS['schedule']) {
            $publishedAt = Carbon::createFromTimeString($request->get('publish_at'));
        }

        $postData = array_merge($request->except('publish_option, published_at'), [
            'is_published' => $isPublished,
            'published_at' => $publishedAt,
            'user_id' => $request->user()->id,
            'image' => '',
        ]);

        Post::create($postData);

        return response()->json([
            'code' => JsonResponse::HTTP_OK,
            'response' => trans('messages.posts.post-added'),
            'redirect' => route('showAllPostsList')
        ]);
    }

    /**
     * Update existing post information.
     *
     * @param int $post
     * @param SavePostRequest $request
     *
     * @return JsonResponse
     */
    public function updatePost($post, SavePostRequest $request): JsonResponse
    {
        $post = Post::withTrashed()->find($post);

        if (null !== $post) {
            $publishedAt = $post->published_at;
            $isPublished = $post->is_published;
            $publishOption = $request->get('publish_option');

            if ($publishOption == Post::PUBLISH_OPTIONS['now'] && (!$post->is_published || $post->isScheduled())) {
                $publishedAt = Carbon::now();
            } elseif ($publishOption == Post::PUBLISH_OPTIONS['draft']) {
                $isPublished = false;
            } elseif ($publishOption == Post::PUBLISH_OPTIONS['schedule']) {
                $publishedAt = Carbon::createFromTimeString($request->get('publish_at'));
            }

            $postData = array_merge($request->except('publish_option, published_at'), [
                'is_published' => $isPublished,
                'published_at' => $publishedAt,
                'user_id' => $request->user()->id,
                'image' => '',
            ]);

            $post->update($postData);

            return response()->json([
                'code' => JsonResponse::HTTP_OK,
                'response' => trans('messages.posts.post-added'),
                'redirect' => route('showAllPostsList')
            ]);
        }

        abort(404);
    }
}
