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
        Schema::create('admins', function (Blueprint $table) {
            $table->id('admin_id'); 
            $table->string('first_name');
            $table->string('last_name'); 
            $table->string('contact_number'); 
            $table->string('password'); 
            $table->timestamps(); 
        });
    }

    public function down()
    {
        Schema::dropIfExists('admins');
    }
};
