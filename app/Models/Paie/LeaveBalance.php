<?php

namespace App\Models\Paie;

use App\Enums\Paie\LeaveType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class LeaveBalance extends Model
{
    use SoftDeletes;

    protected $table = 'paie_leave_balances';

    protected $fillable = [
        'employee_id',
        'type',
        'annee',
        'total',
        'utilise',
        'reste',
    ];

    protected $casts = [
        'annee' => 'integer',
        'total' => 'integer',
        'utilise' => 'integer',
        'reste' => 'integer',
    ];

    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class);
    }

    public function typeLabel(): string
    {
        return LeaveType::tryFrom($this->type)?->label() ?? $this->type;
    }

    public function pourcentageUtilise(): float
    {
        if ($this->total <= 0) {
            return 0;
        }

        return round(($this->utilise / $this->total) * 100, 1);
    }
}
