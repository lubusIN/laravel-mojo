<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMojoPaymentDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mojo_payment_details', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users');
            $table->string('buyer_email');
            $table->string('buyer_name');
            $table->string('buyer_phone');
            $table->string('currency');
            $table->string('amount');
            $table->string('fees');
            $table->string('longurl');
            $table->string('payment_id');
            $table->string('payment_request_id');
            $table->string('purpose');
            $table->string('shorturl')->nullable();
            $table->string('request_status');
            $table->string('payment_status');
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
        Schema::dropIfExists('mojo_payment_details');
    }
}
