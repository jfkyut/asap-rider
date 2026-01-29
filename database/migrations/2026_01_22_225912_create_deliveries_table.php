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
        Schema::create('deliveries', function (Blueprint $table) {
            $table->id();
            $table->enum('type', ['pick_and_drop', 'pasuyo']);
            $table->foreignId('pasuyo_id')->nullable()->constrained()->cascadeOnDelete();
            $table->foreignId('pick_and_drop_id')->nullable()->constrained()->cascadeOnDelete();
            $table->enum('status', [
                'accepted',
                'in_progress',
                'to_pay',
                'completed',
                'cancelled'
            ])->default('accepted');
            $table->decimal('bill_amount', 10, 2)->nullable();
            $table->decimal('distance_travelled', 8, 2)->nullable();
            $table->decimal('total_payment', 10, 2)->nullable();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('deliveries');
    }
};
