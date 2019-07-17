<?php

namespace App;

use Carbon\Carbon;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Post
 *
 * @property int $id
 * @property string $title
 * @property string $description
 * @property string $keywords
 * @property string $content
 * @property string $image
 * @property string $slug
 * @property int $views
 * @property int|null $category_id
 * @property int|null $user_id
 * @property int $is_published
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $published_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \App\User $author
 * @property-read \App\Category|null $category
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Comment[] $comments
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Post findSimilarSlugs($attribute, $config, $slug)
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Post newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Post newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\Post onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Post query()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Post whereCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Post whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Post whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Post whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Post whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Post whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Post whereImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Post whereIsPublished($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Post whereKeywords($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Post wherePublishedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Post whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Post whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Post whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Post whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Post whereViews($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Post withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Post withoutTrashed()
 * @mixin \Eloquent
 */
class Post extends Model
{
    use SoftDeletes, Sluggable;

    public const PUBLISH_OPTIONS = [
        'now' => 'now',
        'draft' => 'draft',
        'schedule' => 'schedule',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'description',
        'keywords',
        'content',
        'image',
        'slug',
        'views',
        'category_id',
        'user_id',
        'is_published',
        'published_at'
    ];

    /**
     * Return the sluggable configuration array for this model.
     *
     * @return array
     */
    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'title'
            ]
        ];
    }

    /**
     * Get all comments for the post.
     *
     * @return HasMany
     */
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    /**
     * Get the parent category.
     *
     * @return BelongsTo
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Get the author of the post.
     *
     * @return BelongsTo
     */
    public function author()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the publish option for the post.
     *
     * @return string
     */
    public function getPublishOption(): string
    {
        if (!$this->is_published) {
            return self::PUBLISH_OPTIONS['draft'];
        }
        if ($this->isScheduled()) {
            return self::PUBLISH_OPTIONS['schedule'];
        }

        return self::PUBLISH_OPTIONS['now'];
    }

    /**
     * Check whether post is scheduled for publishing.
     *
     * @return bool
     */
    public function isScheduled(): bool
    {
        return !$this->trashed() && $this->published_at > Carbon::now();
    }

    /**
     * Get the count of posts for each type
     *
     * @return array
     */
    public static function counts(): array
    {
        $allPostsCount = Post::count();
        $publishedPostsCount = Post::where('is_published', true)->where('published_at', '<=', Carbon::now())->count();
        $scheduledPostsCount = Post::where('is_published', true)->where('published_at', '>', Carbon::now())->count();
        $draftedPostsCount = Post::where('is_published', false)->count();
        $trashedPostsCount = Post::onlyTrashed()->count();

        return [
            'all' => $allPostsCount,
            'published' => $publishedPostsCount,
            'scheduled' => $scheduledPostsCount,
            'drafted' => $draftedPostsCount,
            'trashed' => $trashedPostsCount,
        ];
    }
}
