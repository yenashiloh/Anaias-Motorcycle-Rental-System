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
            $table->string('status')->default('Available'); 
        });
    }
    
    public function down()
    {
        Schema::table('motorcycles', function (Blueprint $table) {
            $table->dropColumn('status');
        });
    }

};
