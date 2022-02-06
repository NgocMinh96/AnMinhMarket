<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateImagesProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('images_products', function (Blueprint $table) {
            $table->unsignedBigInteger('product_list_id');
            $table->unsignedBigInteger('product_image_id');

            //FOREIGN KEY CONSTRAINTS
            $table->foreign('product_list_id')->references('id')->on('product_lists')->onDelete('cascade');
            $table->foreign('product_image_id')->references('id')->on('product_images')->onDelete('cascade');

            //SETTING THE PRIMARY KEYS
            $table->primary(['product_list_id', 'product_image_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('images_products');
    }
}
