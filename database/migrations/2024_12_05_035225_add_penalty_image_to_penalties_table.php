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
            $table->json('penalty_image')->nullable()->after('additional_payment');
        });
    }
    
    public function down()
    {
        Schema::table('penalty', function (Blueprint $table) {
            $table->dropColumn('penalty_image');
        });
    }    
};
