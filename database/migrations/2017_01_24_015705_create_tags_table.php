<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTagsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tags', function (Blueprint $table) {
            $table->engine = 'InnoDB';

            $table->string('slug', 20);
            $table->timestamps();
            $table->string('name', 100);
            $table->boolean('active')->nullable();

            $table->primary('slug');
            $table->index('active');
        });

        Schema::create('post_tags', function (Blueprint $table) {
            $table->engine = 'InnoDB';

            $table->integer('post_id')->unsigned();
            $table->string('tag_slug', 20);

            $table->primary(['post_id', 'tag_slug']);

            $table->foreign('tag_slug')->references('slug')->on('tags')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('post_id')->references('id')->on('posts')->onUpdate('cascade')->onDelete('cascade');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('post_tags');
        Schema::dropIfExists('tags');
    }
}
