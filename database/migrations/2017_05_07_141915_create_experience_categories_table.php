<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExperienceCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('experience_categories', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('experience_id')->references('id')->on('experiences')->default(null);
            $table->integer('category_id')->default(null);
            $table->timestamps();
            $table->unique(['experience_id','category_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('experience_categories');
    }
}
