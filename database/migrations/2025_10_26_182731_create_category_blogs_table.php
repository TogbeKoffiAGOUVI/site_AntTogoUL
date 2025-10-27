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
        Schema::create('category_blogs', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique(); // Nom de la catégorie (ex: "Folklore")
            $table->string('slug')->unique(); // Slug pour les URLs (ex: "folklore")
            $table->text('description')->nullable(); // Description de la catégorie
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('category_blogs');
    }
};
