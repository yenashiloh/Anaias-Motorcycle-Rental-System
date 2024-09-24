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
        Schema::create('motorcycles', function (Blueprint $table) {
            $table->bigIncrements('motor_id');
            $table->string('name');
            $table->string('brand');
            $table->string('model');
            $table->string('cc');
            $table->year('year');
            $table->string('gas');
            $table->string('color');
            $table->string('body_number');
            $table->string('plate_number');
            $table->decimal('price', 10, 2);
            $table->longText('description')->nullable();
            $table->json('images')->nullable(); 
            $table->timestamps();
        });
    }
    
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('motorcycles');
    }
};
