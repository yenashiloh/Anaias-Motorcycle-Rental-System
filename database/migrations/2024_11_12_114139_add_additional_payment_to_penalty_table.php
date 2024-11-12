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
        Schema::table('penalty', function (Blueprint $table) {
            $table->decimal('additional_payment', 10, 2)->after('description')->nullable();
        });
    }
    

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('penalty', function (Blueprint $table) {
            $table->dropColumn('additional_payment');
        });
    }    
};
