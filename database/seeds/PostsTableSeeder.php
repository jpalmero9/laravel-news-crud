<?php

use Illuminate\Database\Seeder;

use Carbon\Carbon;
use Sevenpluss\NewsCrud\Models\User;
use Sevenpluss\NewsCrud\Models\Category;
use Sevenpluss\NewsCrud\Models\Post;

/**
 * Class PostsTableSeeder
 */
class PostsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $time_now = Carbon::now();

        $users = User::all();

        $categories = Category::all();

        $faker = Faker\Factory::create();

        for ($i = 0; $i < 500; $i++) {

            $post = new Post;

            $post->user_id = $users->random(1)->pluck('id')->first();


            $name = $faker->text(80);

            $post->slug = substr(str_slug($name), 0, 50);

            $created_at = $faker->dateTimeBetween('-6 months', '-3 days');

            $post->created_at = Carbon::createFromTimestamp($created_at->getTimestamp());

            $updated_at = $faker->dateTimeBetween($created_at->getTimestamp(), '-3 days');

            $post->updated_at = Carbon::createFromTimestamp($updated_at->getTimestamp());

            $post->published_at = $faker->dateTimeBetween('-2 days', $time_now->getTimestamp());

            $post->category_id = $categories->random(1)->pluck('id')->first();



            if (rand(0, 1)) {

                $post->title = $faker->realText(55);

                $post->description = $faker->realText(155);

                $post->keywords = str_limit(implode(', ', $faker->words(15)), 250, '');

            }

            $post->name = $faker->text(80);

            $post->summary = $faker->text(200);

            $post->story = rand(0, 1) ? $faker->text(400) : null;


            $post->views = rand(0, 300);

            $post->save();
        }
    }
}
