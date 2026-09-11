<?php

namespace App\Models\Paie;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Timesheet extends Model
{
    use SoftDeletes;

    protected $table = 'paie_timesheets';

    protected $fillable = [
        'employee_id',
        'date',
        'heure_debut',
        'heure_fin',
        'pause',
        'heures_totales',
        'heures_sup',
        'statut',
        'approuve_par',
        'notes',
    ];

    protected $casts = [
        'date' => 'date',
        'pause' => 'integer',
        'heures_totales' => 'float',
        'heures_sup' => 'float',
    ];

    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class);
    }

    public function approuvePar(): BelongsTo
    {
        return $this->belongsTo(User::class, 'approuve_par');
    }

    public function calculerHeures(): void
    {
        $debut = \Carbon\Carbon::parse($this->date . ' ' . $this->heure_debut);
        $fin = \Carbon\Carbon::parse($this->date . ' ' . $this->heure_fin);

        if ($fin->lessThan($debut)) {
            $fin->addDay();
        }

        $totalMinutes = $debut->diffInMinutes($fin) - $this->pause;
        $this->heures_totales = max(0, round($totalMinutes / 60, 2));

        $heuresNormales = 8;
        $this->heures_sup = max(0, round($this->heures_totales - $heuresNormales, 2));
    }
}
