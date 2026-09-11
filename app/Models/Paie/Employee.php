<?php

namespace App\Models\Paie;

use App\Enums\Paie\ContractType;
use App\Enums\Paie\EmployeeStatut;
use App\Models\Tenant;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Employee extends Model
{
    use SoftDeletes;

    protected $table = 'paie_employees';

    protected $fillable = [
        'tenant_id',
        'matricule',
        'nom',
        'prenom',
        'email',
        'phone',
        'date_naissance',
        'sexe',
        'situation_familiale',
        'nb_enfants',
        'photo',
        'poste',
        'department_id',
        'date_embauche',
        'type_contrat',
        'duree_contrat',
        'salaire_base',
        'mode_paiement',
        'banque',
        'rib',
        'cnps_numero',
        'statut',
        'notes',
    ];

    protected $casts = [
        'date_naissance' => 'date',
        'date_embauche' => 'date',
        'duree_contrat' => 'date',
        'salaire_base' => 'integer',
        'nb_enfants' => 'integer',
    ];

    protected static function boot(): void
    {
        parent::boot();

        static::creating(function (Employee $employee) {
            if (empty($employee->matricule)) {
                $employee->matricule = self::generateMatricule($employee->tenant_id);
            }
        });
    }

    public static function generateMatricule(int $tenantId): string
    {
        $last = static::where('tenant_id', $tenantId)
            ->orderByDesc('id')
            ->value('matricule');

        $nextNumber = 1;
        if ($last && preg_match('/(\d+)$/', $last, $matches)) {
            $nextNumber = (int) $matches[1] + 1;
        }

        return 'EMP-' . str_pad($nextNumber, 4, '0', STR_PAD_LEFT);
    }

    public function tenant(): BelongsTo
    {
        return $this->belongsTo(Tenant::class);
    }

    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class);
    }

    public function contracts(): HasMany
    {
        return $this->hasMany(Contract::class);
    }

    public function activeContract(): HasOne
    {
        return $this->hasOne(Contract::class)->latestOfMany('date_debut');
    }

    public function payslips(): HasMany
    {
        return $this->hasMany(Payslip::class);
    }

    public function leaves(): HasMany
    {
        return $this->hasMany(Leave::class);
    }

    public function leaveBalances(): HasMany
    {
        return $this->hasMany(LeaveBalance::class);
    }

    public function timesheets(): HasMany
    {
        return $this->hasMany(Timesheet::class);
    }

    public function expenses(): HasMany
    {
        return $this->hasMany(Expense::class);
    }

    public function user(): HasOne
    {
        return $this->hasOne(User::class, 'id')->where('role', 'tenant_user');
    }

    // --- Attributs calculés ---

    public function getNomCompletAttribute(): string
    {
        return "{$this->prenom} {$this->nom}";
    }

    public function getAncienneteAttribute(): int
    {
        return $this->date_embauche?->diffInYears(now()) ?? 0;
    }

    public function getPartsFiscalesAttribute(): float
    {
        $parts = match ($this->situation_familiale) {
            'marie' => 2.0,
            default => 1.0,
        };

        return $parts + ($this->nb_enfants * 0.5);
    }
}
