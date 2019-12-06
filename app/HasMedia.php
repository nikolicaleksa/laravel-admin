<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\HasMedia
 *
 * @property int $id
 * @property int|null $gallery_id
 * @property int|null $media_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\HasMedia newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\HasMedia newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\HasMedia query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\HasMedia whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\HasMedia whereGalleryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\HasMedia whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\HasMedia whereMediaId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\HasMedia whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class HasMedia extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'gallery_id', 'media_id'
    ];
}
