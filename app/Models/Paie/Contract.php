<?php

namespace App\Models\Paie;

use App\Enums\Paie\ContractType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Contract extends Model
{
    use SoftDeletes;

    protected $table = 'paie_contracts';

    protected $fillable = [
        'employee_id',
        'type_contrat',
        'date_debut',
        'date_fin',
        'salaire_base',
        'poste',
        'motif',
        'document_path',
    ];

    protected $casts = [
        'date_debut' => 'date',
        'date_fin' => 'date',
        'salaire_base' => 'integer',
    ];

    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class);
    }

    public function typeLabel(): string
    {
        return ContractType::tryFrom($this->type_contrat)?->label() ?? $this->type_contrat;
    }
}
