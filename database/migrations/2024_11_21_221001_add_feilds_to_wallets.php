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
        Schema::table('wallets', function (Blueprint $table) {
            $table->string('coupon_used_id')->nullable();
            $table->string('coupon_used_string')->nullable();
            $table->tinyInteger('account_source')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('wallets', function (Blueprint $table) {
            $table->dropColumn('coupon_used_id');
            $table->dropColumn('coupon_used_string');
            $table->dropColumn('account_source');
        });
    }
};
