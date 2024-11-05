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
        Schema::create('penalty', function (Blueprint $table) {
            $table->id('penalty_id'); 
            $table->unsignedBigInteger('customer_id'); 
            $table->unsignedBigInteger('driver_id');
            $table->unsignedBigInteger('reservation_id'); 
            $table->string('penalty_type'); 
            $table->text('description')->nullable();
            $table->timestamps(); 
            
            $table->foreign('reservation_id')->references('reservation_id')->on('reservations')->onDelete('cascade');
            $table->foreign('customer_id')->references('customer_id')->on('customers')->onDelete('cascade');
            $table->foreign('driver_id')->references('driver_id')->on('driver_information')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('penalty');
    }
};
