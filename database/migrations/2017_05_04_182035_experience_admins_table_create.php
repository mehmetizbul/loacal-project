<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ExperienceAdminsTableCreate extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('experience_admins', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('experience_id')->default(null);
            $table->integer('user_id')->default(null);
            $table->boolean('main')->default(false);
            $table->timestamps();
            $table->unique(['experience_id','user_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('experience_admins');
    }
}
