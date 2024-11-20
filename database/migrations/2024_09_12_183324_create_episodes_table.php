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
        Schema::create('episodes', function (Blueprint $table) {
            $table->id();
            $table->string('titre');
            $table->text('description');
            $table->string('filename');
            $table->string('disk');
            $table->string('extension');
            $table->string('mime');
            $table->string('size');
            $table->integer('download')->default(0); // Correction ici
            $table->string('path');
            $table->string('url');
            $table->string('path_extrait')->nullable();
            $table->integer('livre_id');
            $table->foreignId('auteur_id')
                ->constrained('auteurs')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('episodes');
    }
};