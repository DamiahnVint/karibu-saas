<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('paie_payslips', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tenant_id')->constrained()->cascadeOnDelete();
            $table->foreignId('employee_id')->constrained('paie_employees')->cascadeOnDelete();
            $table->unsignedTinyInteger('mois');
            $table->unsignedSmallInteger('annee');

            // Éléments bruts
            $table->unsignedInteger('salaire_base');
            $table->unsignedInteger('heures_sup_jour')->default(0);
            $table->unsignedInteger('heures_sup_nuit')->default(0);
            $table->unsignedInteger('total_heures_sup')->default(0);
            $table->unsignedInteger('prime_anciennete')->default(0);
            $table->unsignedInteger('prime_rendement')->default(0);
            $table->unsignedInteger('prime_risque')->default(0);
            $table->unsignedInteger('prime_13eme')->default(0);
            $table->unsignedInteger('indemnite_transport')->default(0);
            $table->unsignedInteger('indemnite_logement')->default(0);
            $table->unsignedInteger('indemnite_responsabilite')->default(0);
            $table->unsignedInteger('avantages_nature')->default(0);
            $table->unsignedInteger('total_primes')->default(0);
            $table->unsignedInteger('total_indemnites')->default(0);
            $table->unsignedInteger('total_brut');

            // CNPS part salarié
            $table->unsignedInteger('cnps_retraite_salarie')->default(0);
            $table->unsignedInteger('cnps_cmu_salarie')->default(0);
            $table->unsignedInteger('total_cnps_salarie')->default(0);

            // CNPS part employeur
            $table->unsignedInteger('cnps_retraite_employeur')->default(0);
            $table->unsignedInteger('cnps_maternite')->default(0);
            $table->unsignedInteger('cnps_pf')->default(0);
            $table->unsignedInteger('cnps_at')->default(0);
            $table->unsignedInteger('cnps_cmu_employeur')->default(0);
            $table->unsignedInteger('total_cnps_employeur')->default(0);

            // ITS
            $table->unsignedInteger('its_base')->default(0);
            $table->unsignedInteger('its_tranche1')->default(0);
            $table->unsignedInteger('its_tranche2')->default(0);
            $table->unsignedInteger('its_tranche3')->default(0);
            $table->unsignedInteger('its_tranche4')->default(0);
            $table->unsignedInteger('its_tranche5')->default(0);
            $table->unsignedInteger('its_brut')->default(0);
            $table->unsignedInteger('its_credit')->default(0);
            $table->unsignedInteger('its_net')->default(0);

            // Résultat
            $table->unsignedInteger('net_a_payer');

            // Statut & workflow
            $table->enum('statut', ['brouillon', 'valide', 'paye'])->default('brouillon');
            $table->foreignId('valide_par')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('valide_le')->nullable();
            $table->timestamp('paye_le')->nullable();
            $table->string('pdf_path')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->unique(['tenant_id', 'employee_id', 'mois', 'annee']);
            $table->index(['tenant_id', 'statut']);
            $table->index(['tenant_id', 'mois', 'annee']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('paie_payslips');
    }
};
