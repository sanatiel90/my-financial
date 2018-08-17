<?php

use Illuminate\Database\Seeder;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      factory(App\Category::class, 50)->create()->each(function ($c) {
        $c->posts()->save(factory(App\Category::class)->make());
      });
    }
}
