<?php

use Illuminate\Database\Seeder;

use Sevenpluss\NewsCrud\Models\Category;

/**
 * Class CategoriesTableSeeder
 */
class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create();

        for ($i=0; $i < 22; $i ++){

            $category = new Category;

            $category->active = 1;

            $name = $faker->unique()->word;

            $category->slug = str_slug($name);

            $category->name = ucfirst($name);

            $category->save();
        }
    }



}
