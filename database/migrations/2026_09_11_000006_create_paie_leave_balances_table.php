<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('paie_leave_balances', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employee_id')->constrained('paie_employees')->cascadeOnDelete();
            $table->enum('type', ['paye', 'maladie', 'maternite', 'paternite', 'sans_solde', 'deces', 'mariage', 'naissance']);
            $table->unsignedSmallInteger('annee');
            $table->unsignedSmallInteger('total')->default(0);
            $table->unsignedSmallInteger('utilise')->default(0);
            $table->unsignedSmallInteger('reste')->default(0);
            $table->timestamps();
            $table->softDeletes();

            $table->unique(['employee_id', 'type', 'annee']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('paie_leave_balances');
    }
};
