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
        Schema::create('recharges', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id')->default(0);
            $table->bigInteger('package_id')->default(0);
            $table->string('payment_id')->nullable();
            $table->string('amount')->nullable();
            $table->string('buyer_name')->nullable();
            $table->string('buyer_phone')->nullable();
            $table->string('unit_price')->nullable();
            $table->string('fees')->nullable();
            $table->string('billing_instrument')->nullable();
            $table->text('raw_json')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('recharges');
    }
};
