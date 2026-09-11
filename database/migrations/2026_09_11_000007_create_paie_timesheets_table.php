<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('paie_timesheets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employee_id')->constrained('paie_employees')->cascadeOnDelete();
            $table->date('date');
            $table->time('heure_debut');
            $table->time('heure_fin');
            $table->unsignedSmallInteger('pause')->default(0); // minutes
            $table->decimal('heures_totales', 5, 2)->default(0);
            $table->decimal('heures_sup', 5, 2)->default(0);
            $table->enum('statut', ['brouillon', 'valide', 'rejette'])->default('brouillon');
            $table->foreignId('approuve_par')->nullable()->constrained('users')->nullOnDelete();
            $table->text('notes')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index(['employee_id', 'date']);
            $table->index(['employee_id', 'statut']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('paie_timesheets');
    }
};
