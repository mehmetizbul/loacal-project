<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBookingRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('booking_requests', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->references('id')->on('users');
            $table->string('sku');
            $table->integer('number_adults')->nullable()->default(0);
            $table->integer('number_children')->nullable()->default(0);
            $table->string('dates')->default("[]");
            $table->string('extras')->default("[]");
            $table->unsignedTinyInteger('transportation')->default(0)->comment("0:nothing 1:Included in price 2:Available upon request (free) 3: Available upon request (extra fee)");
            $table->unsignedTinyInteger('accommodation')->default(0)->comment("0:nothing 1:Included in price 2:Available upon request (free) 3: Available upon request (extra fee)");
            $table->decimal('price_adults',10,2)->default("0.00");
            $table->decimal('price_children',10,2)->default("0.00");
            $table->decimal('price_extras',10,2)->default("0.00");
            $table->boolean('accepted')->default(0);
            $table->boolean('closed')->default(0);
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
        Schema::dropIfExists('booking_requests');
    }
}
