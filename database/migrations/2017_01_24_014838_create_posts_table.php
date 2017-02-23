<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->engine = 'InnoDB';

            $table->increments('id');
            $table->string('slug', 70);
            $table->integer('user_id')->unsigned()->nullable();
            $table->timestamps();
            $table->timestamp('published_at')->nullable();
            $table->integer('category_id')->unsigned()->nullable();
            $table->string('title', 55)->nullable();
            $table->string('description', 155)->nullable();
            $table->string('keywords', 250)->nullable();
            $table->string('name');
            $table->text('summary');
            $table->text('story')->nullable();
            $table->integer('views')->unsigned()->default(0);

            $table->index('slug');
            $table->index('published_at');
            $table->index('user_id');
            $table->index('category_id');

            $table->foreign('category_id')->references('id')->on('categories')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('posts');
    }
}
