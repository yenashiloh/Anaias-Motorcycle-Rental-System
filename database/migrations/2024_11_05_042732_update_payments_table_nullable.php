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
        Schema::table('payments', function (Blueprint $table) {
            $table->string('name')->nullable()->change();
            $table->string('number')->nullable()->change();
            $table->string('receipt')->nullable()->change();
            $table->decimal('amount', 10, 2)->nullable()->change();
            $table->string('image')->nullable()->change();
        });
    }

    public function down()
    {
        Schema::table('payments', function (Blueprint $table) {
            $table->string('name')->nullable(false)->change();
            $table->string('number')->nullable(false)->change();
            $table->string('receipt')->nullable(false)->change();
            $table->decimal('amount', 10, 2)->nullable(false)->change();
            $table->string('image')->nullable(false)->change();
        });
    }
};
