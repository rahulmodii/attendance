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
        Schema::table('settings', function (Blueprint $table) {
            $table->string('name')->nullable();
            $table->string('company_name')->nullable();
            $table->time('in_time')->nullable();
            $table->time('out_time')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('settings', function (Blueprint $table) {
            $table->dropColumn('name');
            $table->dropColumn('company_name');
            $table->dropColumn('in_time');
            $table->dropColumn('out_time');
        });
    }
};
