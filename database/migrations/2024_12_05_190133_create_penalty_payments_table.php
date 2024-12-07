<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('penalty_payments', function (Blueprint $table) {
            $table->id('penalty_payment_id'); 
            $table->unsignedBigInteger('penalty_id');
            $table->unsignedBigInteger('customer_id'); 
            $table->unsignedBigInteger('driver_id');
            $table->unsignedBigInteger('reservation_id'); 
            $table->string('payment_method');
            $table->string('gcash_name')->nullable();
            $table->string('gcash_number')->nullable();
            $table->string('image_receipt')->nullable();
            $table->timestamps();
    
            $table->foreign('penalty_id')->references('penalty_id')->on('penalty')->onDelete('cascade');
            $table->foreign('reservation_id')->references('reservation_id')->on('reservations')->onDelete('cascade');
            $table->foreign('customer_id')->references('customer_id')->on('customers')->onDelete('cascade');
            $table->foreign('driver_id')->references('driver_id')->on('driver_information')->onDelete('cascade');
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('penalty_payments');
    }
    
};
