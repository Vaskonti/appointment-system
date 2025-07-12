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
        Schema::create('reminder_offsets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('appointment_id')->constrained()->onDelete('cascade');
            $table->integer('offset_minutes')->default(15); // Default offset of 15 minutes
            $table->string('timezone')->default('UTC');
            $table->boolean('enabled')->default(true);
            $table->string('recurrence')->default('none'); // Recurrence type, e.g., 'none', 'daily', 'weekly', etc.
            $table->integer('recurrence_interval')->default(1); // Interval for recurrence, e.g., every 1 day/week/month
            $table->integer('max_recurrences')->nullable(); // Maximum number of recurrences, null for unlimited
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reminder_offset');
    }
};
