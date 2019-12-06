<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Media
 *
 * @property int $id
 * @property string $name
 * @property string $file
 * @property string|null $mime_type
 * @property string|null $dimensions
 * @property int $size
 * @property mixed $variants
 * @property int|null $user_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Media newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Media newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Media query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Media whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Media whereDimensions($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Media whereFile($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Media whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Media whereMimeType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Media whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Media whereSize($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Media whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Media whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Media whereVariants($value)
 * @mixin \Eloquent
 */
class Media extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'file', 'mime_type', 'dimensions', 'size', 'variants', 'user_id'
    ];

    /**
     * @param string $size
     *
     * @return string
     */
    public function getImageUrl(string $size): string
    {
        $variants = json_decode($this->variants, true);

        if ('original' == $size) {
            return asset('uploads/' . $this->file);
        } elseif (isset($variants[$size])) {
            return asset('uploads/' . $variants[$size]);
        }

        return '';
    }
}
