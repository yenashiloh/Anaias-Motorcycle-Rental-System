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
        Schema::table('notifications', function (Blueprint $table) {
            $table->unsignedBigInteger('reservation_id')->nullable()->after('customer_id'); // Add the reservation_id column
            $table->foreign('reservation_id')->references('reservation_id')->on('reservations')->onDelete('cascade'); // Create a foreign key constraint
        });
    }

    public function down()
    {
        Schema::table('notifications', function (Blueprint $table) {
            $table->dropForeign(['reservation_id']);
            $table->dropColumn('reservation_id');
        });
    }

};
