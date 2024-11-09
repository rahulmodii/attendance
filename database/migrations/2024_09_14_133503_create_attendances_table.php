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
        Schema::create('attendances', function (Blueprint $table) {
            $table->id();
            // Assuming each attendance is linked to a user
            $table->unsignedBigInteger('user_id');

            // User's mobile number
            $table->string('mobile', 15);

            // Date and time of attendance
            $table->timestamp('date_time')->useCurrent();

            // Type of attendance: 'in' or 'out'
            $table->enum('type', ['0', '1']);
            $table->string('image')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attendances');
    }
};
