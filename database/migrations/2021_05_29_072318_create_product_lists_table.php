<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductListsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_lists', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('code')->nullable();
            $table->string('name')->unique();
            $table->string('slug');
            $table->integer('price')->default(0);
            $table->smallInteger('sale')->default(0);
            $table->string('label')->nullable();
            $table->text('description')->nullable();
            $table->smallInteger('status')->default(0);
            $table->smallInteger('special')->default(0);
            $table->integer('ordering')->default(0);
            $table->string('video')->nullable();
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
        Schema::dropIfExists('product_lists');
    }
}
