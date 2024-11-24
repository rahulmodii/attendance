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
        Schema::create('domains', function (Blueprint $table) {
            $table->id();
            $table->string('domain')->nullable();
            $table->bigInteger('maintainer_id')->default(0);
            $table->string('name');
            $table->string('support_contact_number');
            $table->string('logo');
            $table->string('address');
            $table->string('mail');
            $table->string('banner');
            $table->string('custom_image_1');
            $table->string('custom_image_2');
            $table->string('custom_image_3');
            $table->tinyInteger('status')->default(1);
            $table->string('pg_type')->nullable();
            $table->json('credentials')->nullable();
            $table->tinyInteger('is_requested')->default(0);
            $table->tinyInteger('is_approved')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('domains');
    }
};
