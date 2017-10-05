<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExperiencesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('experiences', function (Blueprint $table) {
            $table->increments('id')->index();
            $table->string('sku');
            $table->integer('user_id')->unsigned();
            $table->string('title');
            $table->text('description');
            $table->boolean('child_friendly')->default(0);
            $table->boolean('disabled_friendly')->default(0);
            $table->string('availability')->default("[]");
            $table->unsignedTinyInteger('transportation')->default(0)->comment("0:nothing 1:Included in price 2:Available upon request (free) 3: Available upon request (extra fee)");
            $table->unsignedTinyInteger('accommodation')->default(0)->comment("0:nothing 1:Included in price 2:Available upon request (free) 3: Available upon request (extra fee)");
            $table->string('slug')->unique();
            $table->integer('menu_order')->unsigned();
            $table->decimal('duration')->default(0);
            $table->string('duration_unit')->default("hour");
            $table->text('purchase_note');
            $table->text('cancellation_policy');
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
        Schema::dropIfExists('experiences');
    }
}