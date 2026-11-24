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
        Schema::create('items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('category_id')->constrained('categories')->restrictOnDelete();
            $table->string('name');
            $table->enum('type', ['lost', 'found']);
            $table->text('description');
            $table->string('photo')->nullable();
            $table->string('location');
            $table->date('incident_date');
            $table->time('incident_time')->nullable();
            $table->string('status', 30)->default('menunggu'); // menunggu, dipublikasikan, ditolak, dibatalkan, selesai
            $table->timestamps();

            $table->index('type');
            $table->index('status');
            $table->index('category_id');
            $table->index('incident_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('items');
    }
};
