<?php

use Illuminate\Database\Seeder;

use Sevenpluss\NewsCrud\Models\Tag;
use Sevenpluss\NewsCrud\Models\Post;

/**
 * Class TagsTableSeeder
 */
class TagsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // fill table data
        $this->fillData();

        $this->attachRandomTagsForPosts();
    }

    /**
     * @return void
     */
    protected function fillData()
    {
        $faker = Faker\Factory::create();

        for ($i = 0; $i < 15; $i++) {

            $tag = new Tag;

            $tag_name = $faker->unique()->word;

            $tag->slug = str_slug($tag_name);

            $tag->name = $tag_name;

            $tag->active = 1;

            $tag->save();
        }
    }

    /**
     * @return void
     */
    protected function attachRandomTagsForPosts()
    {
        $posts = Post::all();

        $tags = Tag::all();

        foreach ($posts as $post){
            $tags_slug = $tags->random(rand(1, 3))->pluck('slug');
            $post->tags()->sync($tags_slug);
        }
    }

}
