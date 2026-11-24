<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('category_id')->constrained('categories')->cascadeOnDelete();
            $table->string('name', 100);
            $table->enum('type', ['lost', 'found']);
            $table->text('description');
            $table->string('photo')->nullable();
            $table->string('location', 255);
            $table->date('incident_date');
            $table->time('incident_time')->nullable();
            $table->enum('status', ['menunggu', 'dipublikasikan', 'ditolak', 'dibatalkan', 'selesai'])->default('menunggu');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('items');
    }
};
