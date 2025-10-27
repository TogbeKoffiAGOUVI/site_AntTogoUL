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
        Schema::create('profile_photos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Colonne me permetant de lier la photo à l'utilisateur ( en gros ma clé étrangère)
            $table->string('path'); // Chemin d'accès au fichier sur le disque
            $table->string('original_name')->nullable(); // Nom original du fichier
            $table->string('mime_type', 50)->nullable();  // Autres informations qui pourraient être utiles
            $table->unsignedInteger('size')->nullable(); // en octets
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('profile_photos');
    }
};
