<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('claims', function (Blueprint $table) {
            $table->id();
            $table->foreignId('item_id')->constrained('items')->cascadeOnDelete();
            $table->foreignId('submitter_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('verifier_id')->nullable()->constrained('users')->nullOnDelete();
            $table->enum('type', ['klaim', 'penemuan']);
            $table->text('ownership_description')->nullable();
            $table->text('finding_description')->nullable();
            $table->string('finding_location', 255)->nullable();
            $table->dateTime('finding_time')->nullable();
            $table->string('storage_location', 255)->nullable();
            $table->string('evidence')->nullable();
            $table->enum('status', ['diajukan', 'diterima', 'ditolak'])->default('diajukan');
            $table->dateTime('verified_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('claims');
    }
};
