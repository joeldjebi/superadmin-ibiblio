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
        Schema::create('wallet_transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->decimal('montant', 10, 2); // Montant de la transaction
            $table->enum('type_transaction', ['rechargement', 'achat_livre', 'abonnement']); // Type d'opération
            $table->foreignId('livre_id')->nullable()->constrained('livres')->onDelete('set null'); // Lié à l'achat de livre
            $table->foreignId('forfait_id')->nullable()->constrained('forfaits')->onDelete('set null'); // Lié à l'achat d'abonnement
            $table->timestamp('date_transaction')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('wallet_transactions');
    }
};