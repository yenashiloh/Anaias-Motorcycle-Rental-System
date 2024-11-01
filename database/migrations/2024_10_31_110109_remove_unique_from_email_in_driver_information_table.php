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
        Schema::table('driver_information', function (Blueprint $table) {
            $table->dropUnique(['email']); 
        });
    }

    public function down()
    {
        Schema::table('driver_information', function (Blueprint $table) {
            $table->unique('email');
        });
    }
};
