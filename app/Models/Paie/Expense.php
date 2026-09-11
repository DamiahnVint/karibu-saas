<?php

namespace App\Models\Paie;

use App\Enums\Paie\ExpenseCategory;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Expense extends Model
{
    use SoftDeletes;

    protected $table = 'paie_expenses';

    protected $fillable = [
        'employee_id',
        'date',
        'categorie',
        'montant',
        'description',
        'justificatif_path',
        'statut',
        'approuve_par',
        'rembourse_le',
        'notes',
    ];

    protected $casts = [
        'date' => 'date',
        'montant' => 'integer',
        'rembourse_le' => 'datetime',
    ];

    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class);
    }

    public function approuvePar(): BelongsTo
    {
        return $this->belongsTo(User::class, 'approuve_par');
    }

    public function categorieLabel(): string
    {
        return ExpenseCategory::tryFrom($this->categorie)?->label() ?? $this->categorie;
    }
}
