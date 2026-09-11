<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('paie_leaves', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employee_id')->constrained('paie_employees')->cascadeOnDelete();
            $table->enum('type', ['paye', 'maladie', 'maternite', 'paternite', 'sans_solde', 'deces', 'mariage', 'naissance']);
            $table->date('date_debut');
            $table->date('date_fin');
            $table->unsignedSmallInteger('nb_jours');
            $table->text('motif')->nullable();
            $table->enum('statut', ['en_attente', 'approuve', 'rejette'])->default('en_attente');
            $table->foreignId('approuve_par')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('approuve_le')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index(['employee_id', 'statut']);
            $table->index(['employee_id', 'date_debut', 'date_fin']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('paie_leaves');
    }
};
