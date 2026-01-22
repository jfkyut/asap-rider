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
        Schema::create('pick_and_drops', function (Blueprint $table) {
            $table->id();
            $table->longText('sender_location');
            $table->longText('sender_location_coordinates')->nullable();
            $table->string('sender_full_name');
            $table->string('sender_phone');
            $table->longText('sender_note')->nullable();
            $table->longText('item_description')->nullable();
            $table->longText('receiver_location');
            $table->longText('receiver_location_coordinates')->nullable();
            $table->string('receiver_full_name');
            $table->string('receiver_phone');
            $table->longText('receiver_note')->nullable();
            $table->enum('status', [
                'pending',
                'accepted',
                'in_progress', 
                'completed'
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
        Schema::dropIfExists('pick_and_drops');
    }
};
