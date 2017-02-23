<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

use Sevenpluss\NewsCrud\Models\Post;
use Sevenpluss\NewsCrud\Models\User;

/**
 * Class CommentsTableSeeder
 */
class CommentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $posts = Post::published()->get();

        if($posts->isNotEmpty()){

            $comment_limit = [1, 15];

            $faker = Faker\Factory::create();

            $users = User::all();

            $time_now = Carbon::now();

            foreach ($posts as $post) {

                if (!is_null($post)) {

                    $limit = rand($comment_limit[0], $comment_limit[1]);

                    for ($i = 0; $i < $limit; $i++) {

                        // create comments for register users
                        $post->comments()->create([
                            'post_id' => $post->id,
                            'created_at' => $faker->dateTimeBetween('-3 days', $time_now->getTimestamp()),
                            'user_id' => $users->random(1)->pluck('id')->first(),
                            'content' => $faker->unique()->realText(100),
                        ]);


                        // create comments for guest users
                        $post->comments()->create([
                            'post_id' => $post->id,
                            'created_at' => $faker->dateTimeBetween('-3 days', $time_now->getTimestamp()),
                            'email' => $faker->freeEmail,
                            'name' => $faker->firstName,
                            'content' => $faker->unique()->realText(100),
                        ]);
                    }
                }
            }
        }
    }
}
