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
        Schema::create('messages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete(); // recipient
            $table->foreignId('sender_id')->nullable()->constrained('users')->nullOnDelete(); // who sent it
            $table->text('body'); // full message content
            $table->string('preview')->nullable(); // truncated preview
            $table->enum('type', ['pasuyo', 'pickup', 'support'])->default('pasuyo');
            $table->unsignedBigInteger('related_id')->nullable(); // Pasuyo/PickAndDrop ID
            $table->string('related_type')->nullable(); // 'App\Models\Pasuyo\Pasuyo' or 'App\Models\PickAndDrop\PickAndDrop'
            $table->boolean('is_read')->default(false);
            $table->timestamp('read_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('messages');
    }
};
