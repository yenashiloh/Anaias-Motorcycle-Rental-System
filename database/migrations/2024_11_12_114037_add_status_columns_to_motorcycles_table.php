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
        Schema::table('motorcycles', function (Blueprint $table) {
            // Add new columns
            $table->boolean('engine_status')->default(false);
            $table->boolean('brake_status')->default(false);
            $table->boolean('tire_condition')->default(false);
            $table->boolean('oil_status')->default(false);
            $table->boolean('lights_status')->default(false);
            $table->boolean('overall_condition')->default(false);
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('motorcycles', function (Blueprint $table) {
            //
        });
    }
};
