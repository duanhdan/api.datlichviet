<?php

use Faker\Generator as Faker;

$factory->define(DatLichVietAPI\Models\News::class, function (Faker $faker, $attributes) {
    $title = $faker->sentence;
    $slug = str_slug($title);

    return [
    	'category_id' => $attributes['category_id'],
    	'system_user_id' => 1,
        'title' => $title,
        'slug' => $slug,
        'description' => $faker->paragraph,
        'content' => $faker->paragraph,
        'image' => 'https://loremflickr.com/200/200',
        'status' => 1
    ];
});
