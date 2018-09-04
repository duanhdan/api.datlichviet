<?php

use Illuminate\Database\Seeder;

class NewsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(DatLichVietAPI\Models\Category::class, 5)->create()->each(function ($c) {
        	factory(DatLichVietAPI\Models\News::class, rand(6, 9))->create(['category_id' => $c->id]);
        });
    }
}
