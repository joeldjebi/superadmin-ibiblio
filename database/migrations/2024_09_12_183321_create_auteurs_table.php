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
        // Création de la table 'auteurs'
        Schema::create('auteurs', function (Blueprint $table) {
            $table->id();
            $table->string('nom');
            $table->string('prenoms');
            $table->string('email')->unique();
            $table->string('mobile')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            // $table->softDeletes(); // Ajout de la colonne 'deleted_at' pour la suppression logique
            $table->timestamps();
        });

        // // Mise à jour de la table 'livres'
        // Schema::table('livres', function (Blueprint $table) {
        //     $table->foreignId('auteur_id')->nullable()->constrained('auteurs')->onDelete('set null'); // Ajout de la clé étrangère
        // });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Suppression de la clé étrangère et colonne de la table 'livres'
        // Schema::table('livres', function (Blueprint $table) {
        //     $table->dropForeign(['auteur_id']);
        //     $table->dropColumn('auteur_id');
        // });

        // Suppression de la table 'auteurs'
        Schema::dropIfExists('auteurs');
    }
};