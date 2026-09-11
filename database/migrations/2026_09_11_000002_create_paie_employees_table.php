<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('paie_employees', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tenant_id')->constrained()->cascadeOnDelete();
            $table->string('matricule', 20);
            $table->string('nom');
            $table->string('prenom');
            $table->string('email')->nullable();
            $table->string('phone', 20)->nullable();
            $table->date('date_naissance')->nullable();
            $table->enum('sexe', ['M', 'F'])->nullable();
            $table->enum('situation_familiale', ['celibataire', 'marie', 'divorce', 'veuf'])->default('celibataire');
            $table->unsignedSmallInteger('nb_enfants')->default(0);
            $table->string('photo')->nullable();
            $table->string('poste')->nullable();
            $table->foreignId('department_id')->nullable()->constrained('paie_departments')->nullOnDelete();
            $table->date('date_embauche');
            $table->enum('type_contrat', ['cdi', 'cdd', 'saisonnier', 'stage'])->default('cdi');
            $table->date('duree_contrat')->nullable();
            $table->unsignedInteger('salaire_base');
            $table->enum('mode_paiement', ['virement', 'cheque', 'especes', 'mobile_money'])->default('virement');
            $table->string('banque')->nullable();
            $table->string('rib', 30)->nullable();
            $table->string('cnps_numero', 20)->nullable();
            $table->enum('statut', ['actif', 'inactif', 'suspendu', 'radie'])->default('actif');
            $table->text('notes')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->unique(['tenant_id', 'matricule']);
            $table->index(['tenant_id', 'statut']);
            $table->index(['tenant_id', 'department_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('paie_employees');
    }
};
