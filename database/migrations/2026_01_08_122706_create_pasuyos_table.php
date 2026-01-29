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
        Schema::create('pasuyos', function (Blueprint $table) {
            $table->id();
            $table->longText('location');
            $table->longText('location_coordinates')->nullable();
            $table->string('full_name');
            $table->string('phone');
            $table->longText('note')->nullable();
            $table->longText('content');
            $table->string('budget');
            $table->enum('status', [
                'pending',
                'accepted',
                'in_progress',
                'to_pay',
                'completed',
                'cancelled'
            ])->default('pending');
            $table->string('payment_method')->nullable();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pasuyos');
    }
};
