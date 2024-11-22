<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('motorcycles', function (Blueprint $table) {
            $table->string('archive_reason')->nullable();
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('motorcycles', function (Blueprint $table) {
            $table->dropColumn('archive_reason');
        });
    }
};
