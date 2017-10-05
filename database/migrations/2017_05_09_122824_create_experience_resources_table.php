<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExperienceResourcesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('experience_resources', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('experience_id')->references('id')->on('experiences')->default(null);
            $table->string('title')->default('');
            $table->decimal('cost',10,2)->default("0.00");
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
        Schema::dropIfExists('experience_resources');
    }
}
