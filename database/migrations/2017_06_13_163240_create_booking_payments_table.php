<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBookingPaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('booking_payments', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('booking_id')->references('id')->on('booking_requests');
            $table->string('name')->default('');
            $table->integer('user_id')->references('id')->on('users');
            $table->decimal('amount',10,2)->default("0.00");
            $table->string('payment_id')->default('');
            $table->text('purchase_note');
            $table->text('serialized_booking');
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
        Schema::dropIfExists('booking_payments');
    }
}
