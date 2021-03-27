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
            $table->increments('id');
            $table->string('code');
            $table->integer('category_id')->nullable();
            $table->string('title');
            $table->string('slug')->nullable();
            $table->string('tags')->nullable();
            $table->string('image')->nullable();
            $table->string('template')->default('Default Template');
            $table->text('excerpt');
            $table->text('content');
            $table->string('status')->default('published');
            $table->boolean('is_commentable')->default(true);
            $table->boolean('is_qnchor')->default(true);
            $table->datetime('published_at');
            $table->integer('last_updated_by')->nullable();
            $table->timestamps();
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
