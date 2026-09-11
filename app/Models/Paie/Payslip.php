<?php

namespace App\Models\Paie;

use App\Enums\Paie\PayslipStatus;
use App\Models\Tenant;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Payslip extends Model
{
    use SoftDeletes;

    protected $table = 'paie_payslips';

    protected $fillable = [
        'tenant_id',
        'employee_id',
        'mois',
        'annee',
        'salaire_base',
        'heures_sup_jour',
        'heures_sup_nuit',
        'total_heures_sup',
        'prime_anciennete',
        'prime_rendement',
        'prime_risque',
        'prime_13eme',
        'indemnite_transport',
        'indemnite_logement',
        'indemnite_responsabilite',
        'avantages_nature',
        'total_primes',
        'total_indemnites',
        'total_brut',
        'cnps_retraite_salarie',
        'cnps_cmu_salarie',
        'total_cnps_salarie',
        'cnps_retraite_employeur',
        'cnps_maternite',
        'cnps_pf',
        'cnps_at',
        'cnps_cmu_employeur',
        'total_cnps_employeur',
        'its_base',
        'its_tranche1',
        'its_tranche2',
        'its_tranche3',
        'its_tranche4',
        'its_tranche5',
        'its_brut',
        'its_credit',
        'its_net',
        'net_a_payer',
        'statut',
        'valide_par',
        'valide_le',
        'paye_le',
        'pdf_path',
        'notes',
    ];

    protected $casts = [
        'mois' => 'integer',
        'annee' => 'integer',
        'salaire_base' => 'integer',
        'heures_sup_jour' => 'integer',
        'heures_sup_nuit' => 'integer',
        'total_heures_sup' => 'integer',
        'prime_anciennete' => 'integer',
        'prime_rendement' => 'integer',
        'prime_risque' => 'integer',
        'prime_13eme' => 'integer',
        'indemnite_transport' => 'integer',
        'indemnite_logement' => 'integer',
        'indemnite_responsabilite' => 'integer',
        'avantages_nature' => 'integer',
        'total_primes' => 'integer',
        'total_indemnites' => 'integer',
        'total_brut' => 'integer',
        'cnps_retraite_salarie' => 'integer',
        'cnps_cmu_salarie' => 'integer',
        'total_cnps_salarie' => 'integer',
        'cnps_retraite_employeur' => 'integer',
        'cnps_maternite' => 'integer',
        'cnps_pf' => 'integer',
        'cnps_at' => 'integer',
        'cnps_cmu_employeur' => 'integer',
        'total_cnps_employeur' => 'integer',
        'its_base' => 'integer',
        'its_tranche1' => 'integer',
        'its_tranche2' => 'integer',
        'its_tranche3' => 'integer',
        'its_tranche4' => 'integer',
        'its_tranche5' => 'integer',
        'its_brut' => 'integer',
        'its_credit' => 'integer',
        'its_net' => 'integer',
        'net_a_payer' => 'integer',
        'valide_le' => 'datetime',
        'paye_le' => 'datetime',
    ];

    public function tenant(): BelongsTo
    {
        return $this->belongsTo(Tenant::class);
    }

    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class);
    }

    public function validePar(): BelongsTo
    {
        return $this->belongsTo(User::class, 'valide_par');
    }

    public function status(): PayslipStatus
    {
        return PayslipStatus::tryFrom($this->statut) ?? PayslipStatus::BROUILLON;
    }

    public function moisLabel(): string
    {
        $months = [
            1 => 'Janvier', 2 => 'Février', 3 => 'Mars', 4 => 'Avril',
            5 => 'Mai', 6 => 'Juin', 7 => 'Juillet', 8 => 'Août',
            9 => 'Septembre', 10 => 'Octobre', 11 => 'Novembre', 12 => 'Décembre',
        ];

        return ($months[$this->mois] ?? $this->mois) . ' ' . $this->annee;
    }

    public function isEditable(): bool
    {
        return $this->status()->isEditable();
    }
}
