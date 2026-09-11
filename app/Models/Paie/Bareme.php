<?php

namespace App\Models\Paie;

use App\Models\Tenant;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Bareme extends Model
{
    use SoftDeletes;

    protected $table = 'paie_baremes';

    protected $fillable = [
        'tenant_id',
        'type',
        'config',
        'annee',
        'actif',
    ];

    protected $casts = [
        'config' => 'array',
        'annee' => 'integer',
        'actif' => 'boolean',
    ];

    public function tenant(): BelongsTo
    {
        return $this->belongsTo(Tenant::class);
    }

    public static function getDefaultConfig(string $type): array
    {
        $path = database_path("baremes/{$type}_2026.json");

        if (!file_exists($path)) {
            return [];
        }

        return json_decode(file_get_contents($path), true) ?? [];
    }
}
