<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('paie_contracts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employee_id')->constrained('paie_employees')->cascadeOnDelete();
            $table->enum('type_contrat', ['cdi', 'cdd', 'saisonnier', 'stage']);
            $table->date('date_debut');
            $table->date('date_fin')->nullable();
            $table->unsignedInteger('salaire_base');
            $table->string('poste')->nullable();
            $table->string('motif')->nullable();
            $table->string('document_path')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index(['employee_id', 'date_debut']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('paie_contracts');
    }
};
