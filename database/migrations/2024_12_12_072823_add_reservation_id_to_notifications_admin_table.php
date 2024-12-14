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
        Schema::table('notifications_admin', function (Blueprint $table) {
            $table->unsignedBigInteger('reservation_id')->after('customer_id')->nullable(); 
        });
    }
    
    public function down()
    {
        Schema::table('notifications_admin', function (Blueprint $table) {
            $table->dropColumn('reservation_id');
        });
    }
    
};
