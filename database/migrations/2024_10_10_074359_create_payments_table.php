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
        Schema::create('payments', function (Blueprint $table) {
            $table->id('payment_id'); // Primary key
            $table->unsignedBigInteger('customer_id'); // Foreign key
            $table->unsignedBigInteger('motor_id'); 
            $table->string('name'); // Name of the payer
            $table->string('number'); // Payment number (e.g., transaction ID)
            $table->string('receipt'); // Receipt number
            $table->string('image'); // Path to the uploaded image
            $table->timestamps(); // Created at and updated at timestamps

            // Foreign key constraint
            $table->foreign('customer_id')->references('customer_id')->on('customers')->onDelete('cascade');
            $table->foreign('motor_id')->references('motor_id')->on('motorcycles')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('payments');
    }
};
