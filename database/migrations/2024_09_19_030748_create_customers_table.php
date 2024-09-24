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
        Schema::create('customers', function (Blueprint $table) {
            $table->id('customer_id'); 
            $table->string('first_name');
            $table->string('last_name');
            $table->string('email')->unique();
            $table->text('address');
            $table->date('birthdate');
            $table->enum('gender', ['Male', 'Female']);
            $table->string('contact_number');
            $table->string('driver_license'); 
            $table->string('password');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('customers');
    }
};
