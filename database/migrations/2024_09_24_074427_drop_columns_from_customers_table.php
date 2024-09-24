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
        Schema::table('customers', function (Blueprint $table) {
            $table->dropColumn([
                'first_name', 
                'last_name', 
                'address', 
                'birthdate', 
                'gender', 
                'contact_number', 
                'driver_license'
            ]);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('customers', function (Blueprint $table) {
            $table->string('first_name', 255)->nullable();
            $table->string('last_name', 255)->nullable();
            $table->text('address')->nullable();
            $table->date('birthdate')->nullable();
            $table->enum('gender', ['Male', 'Female'])->nullable();
            $table->string('contact_number', 255)->nullable();
            $table->string('driver_license')->nullable();
        });
    }
};
