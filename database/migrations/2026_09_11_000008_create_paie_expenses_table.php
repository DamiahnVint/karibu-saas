<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('paie_expenses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employee_id')->constrained('paie_employees')->cascadeOnDelete();
            $table->date('date');
            $table->enum('categorie', ['transport', 'hebergement', 'repas', 'fournitures', 'autre']);
            $table->unsignedInteger('montant');
            $table->text('description')->nullable();
            $table->string('justificatif_path')->nullable();
            $table->enum('statut', ['en_attente', 'approuve', 'rejette', 'rembourse'])->default('en_attente');
            $table->foreignId('approuve_par')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('rembourse_le')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index(['employee_id', 'statut']);
            $table->index(['employee_id', 'date']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('paie_expenses');
    }
};
