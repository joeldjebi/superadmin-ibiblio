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
        Schema::create('livres', function (Blueprint $table) {
            $table->id();
            $table->string('titre');
            $table->decimal('amount', 10, 2)->default(0.00);
            $table->enum('acces_livre', ['gratuit', 'achat', 'abonnement', 'achat_et_abonnement'])->default('gratuit');
            $table->boolean('vedette')->default(0);
            $table->string('mot_cle');
            $table->string('lecture_cible');
            $table->string('edition_du_livre');
            $table->string('nombre_de_page', 10);
            $table->string('annee_publication', 10);
            $table->string('file_type', 100);
            $table->integer('statut')->default(1)->comment('0 => désactivé par l\'admin, 1 => actif, 2 => désactivé par l\'auteur');
            $table->text('breve_description');
            $table->text('description');
            $table->string('image_cover');
            $table->foreignId('type_publication_id')->constrained('type_publications')->onDelete('cascade');
            $table->foreignId('auteur_id')->constrained('auteurs')->onDelete('cascade');
            $table->foreignId('categorie_id')->constrained('categories')->onDelete('cascade');
            $table->foreignId('editeur_id')->constrained('editeurs')->onDelete('cascade');
            $table->foreignId('episode_id')->nullable()->constrained('episodes')->onDelete('set null');
            $table->foreignId('chapitre_id')->nullable()->constrained('chapitres')->onDelete('set null');
            $table->foreignId('pays_id')->constrained('pays')->onDelete('cascade');
            $table->foreignId('file_id')->nullable()->constrained('files')->onDelete('set null');
            $table->foreignId('langue_id')->constrained('langues')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('livres');
    }
};