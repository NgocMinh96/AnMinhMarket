<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCategoriesPostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categories_posts', function (Blueprint $table) {
            $table->unsignedBigInteger('post_categories_id');
            $table->unsignedBigInteger('post_lists_id');

            //FOREIGN KEY CONSTRAINTS
            $table->foreign('post_categories_id')->references('id')->on('post_categories')->onDelete('cascade');
            $table->foreign('post_lists_id')->references('id')->on('post_lists')->onDelete('cascade');

            //SETTING THE PRIMARY KEYS
            $table->primary(['post_categories_id', 'post_lists_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('categories_posts');
    }
}
