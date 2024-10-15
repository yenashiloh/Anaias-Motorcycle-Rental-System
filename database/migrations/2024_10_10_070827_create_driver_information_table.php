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
        Schema::create('driver_information', function (Blueprint $table) {
            $table->id('driver_id'); 
            $table->unsignedBigInteger('customer_id'); 
            $table->string('first_name');
            $table->string('last_name'); 
            $table->string('email')->unique(); 
            $table->string('contact_number'); 
            $table->string('address'); 
            $table->date('birthdate');
            $table->enum('gender', ['male', 'female', 'other']); 
            $table->string('driver_license'); 
            $table->timestamps(); 

            
            $table->foreign('customer_id')->references('customer_id')->on('customers')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('driver_information');
    }
};
