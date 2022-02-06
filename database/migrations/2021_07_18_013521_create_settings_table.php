<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->string('favicon')->nullable();
            $table->string('logo')->nullable();
            $table->string('banner')->nullable();
            $table->string('brand')->nullable();
            $table->string('color')->nullable();
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->text('address')->nullable();
            $table->text('map')->nullable();
            $table->text('facebook')->nullable();
            $table->text('messenger')->nullable();
            $table->text('youtube')->nullable();
            $table->text('font')->nullable();
            $table->text('keyword')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('settings');
    }
}
