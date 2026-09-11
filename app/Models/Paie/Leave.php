<?php

namespace App\Models\Paie;

use App\Enums\Paie\LeaveStatut;
use App\Enums\Paie\LeaveType;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Leave extends Model
{
    use SoftDeletes;

    protected $table = 'paie_leaves';

    protected $fillable = [
        'employee_id',
        'type',
        'date_debut',
        'date_fin',
        'nb_jours',
        'motif',
        'statut',
        'approuve_par',
        'approuve_le',
        'notes',
    ];

    protected $casts = [
        'date_debut' => 'date',
        'date_fin' => 'date',
        'nb_jours' => 'integer',
        'approuve_le' => 'datetime',
    ];

    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class);
    }

    public function approuvePar(): BelongsTo
    {
        return $this->belongsTo(User::class, 'approuve_par');
    }

    public function typeEnum(): LeaveType
    {
        return LeaveType::tryFrom($this->type) ?? LeaveType::PAYE;
    }

    public function statutEnum(): LeaveStatut
    {
        return LeaveStatut::tryFrom($this->statut) ?? LeaveStatut::EN_ATTENTE;
    }

    public function isPaid(): bool
    {
        return $this->typeEnum()->isPaid();
    }
}
