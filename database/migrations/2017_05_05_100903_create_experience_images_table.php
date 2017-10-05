<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExperienceImagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('experience_images', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('experience_id')->references('id')->on('experiences')->default(null);
            $table->string('image_file')->default("");
            $table->string('icon_file')->default("");
            $table->boolean('thumbnail')->default(0);
            $table->timestamps();
            $table->unique(['experience_id','image_file']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('experience_images');
    }
}
