<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Comment;
use App\Post;
use Faker\Generator as Faker;

$factory->define(Comment::class, function (Faker $faker) {
    $post = Post::all()->random();
    $created_at = $faker->dateTimeBetween($post->created_at, 'now');

    return [
        'name' => $faker->name,
        'content' => $faker->realText(),
        'ip' => $faker->ipv4,
        'is_approved' => $faker->boolean,
        'post_id' => $post->id,
        'created_at' => $created_at,
        'updated_at' => $created_at,
    ];
});
