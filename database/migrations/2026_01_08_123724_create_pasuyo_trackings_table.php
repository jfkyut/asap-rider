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
        Schema::create('pasuyo_trackings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pasuyo_id')->constrained()->cascadeOnDelete();
            $table->longText('status_update');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pasuyo_trackings');
    }
};
