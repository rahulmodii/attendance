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
        Schema::table('users', function (Blueprint $table) {
            $table->string('domain')->nullable();
            $table->string('white_label_webhook')->nullable();
            $table->string('is_white_label')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('domain');
            $table->dropColumn('white_label_webhook');
            $table->dropColumn('is_white_label');
        });
    }
};
