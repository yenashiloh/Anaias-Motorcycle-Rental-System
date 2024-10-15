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
        Schema::create('reservations', function (Blueprint $table) {
            $table->id('reservation_id'); 
            $table->unsignedBigInteger('customer_id');
            $table->unsignedBigInteger('motor_id');
            $table->date('rental_start_date')->nullable();
            $table->date('rental_end_date')->nullable();
            $table->dateTime('pick_up'); 
            $table->dateTime('drop_off'); 
            $table->string('riding');
            $table->decimal('total', 10, 2);
            $table->timestamps(); 

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
        Schema::dropIfExists('reservations');
    }
};
