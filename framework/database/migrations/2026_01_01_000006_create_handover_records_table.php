<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('handover_records', function (Blueprint $table) {
            $table->id();
            $table->foreignId('item_id')->constrained('items')->cascadeOnDelete();
            $table->foreignId('claim_id')->constrained('claims')->cascadeOnDelete();
            $table->foreignId('receiver_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('officer_id')->constrained('users')->cascadeOnDelete();
            $table->dateTime('handed_over_at');
            $table->text('return_note');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('handover_records');
    }
};
