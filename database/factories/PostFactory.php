<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Category;
use App\Post;
use App\User;
use Faker\Generator as Faker;
use Cviebrock\EloquentSluggable\Services\SlugService;

$factory->define(Post::class, function (Faker $faker) {
    $postTitle = $faker->text(60);
    $postKeywords = implode(', ', $faker->words(7));
    $category = Category::all()->random();
    $user = User::all()->random();
    $created_at = $faker->dateTimeBetween($category->created_at, 'now');
    $published = $faker->numberBetween(1, 10) < 9;
    $publishedAt = $deletedAt = null;

    if ($published) {
        if ($faker->numberBetween(1, 6) % 6 === 0) {
            $publishedAt = $faker->dateTimeBetween($created_at, '+2 months');
        } else {
            $publishedAt = $created_at;
        }
    }

    if ($faker->numberBetween(1, 10) % 10 === 0) {
        $deletedAt = $faker->dateTimeBetween($created_at, 'now');
    }

    return [
        'title' => $postTitle,
        'description' => $faker->text(160),
        'keywords' => $postKeywords,
        'content' => $faker->realText(2048),
        'image' => '',
        'slug' => SlugService::createSlug(Post::class, 'slug', $postTitle),
        'views' => $faker->numberBetween(0, 2019),
        'category_id' => $category->id,
        'user_id' => $user->id,
        'is_published' => $published,
        'created_at' => $created_at,
        'updated_at' => $created_at,
        'published_at' => $publishedAt,
        'deleted_at' => $deletedAt
    ];
});
