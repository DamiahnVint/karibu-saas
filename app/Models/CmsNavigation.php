<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class CmsNavigation extends Model
{
    protected $table = 'cms_navigations';

    protected $fillable = [
        'location',
        'items',
    ];

    protected $casts = [
        'items' => 'array',
    ];

    /**
     * Récupère les éléments de navigation par emplacement.
     * Cache Redis (1h).
     */
    public static function getItems(string $location): array
    {
        return Cache::remember("nav_{$location}", 3600, function () use ($location) {
            $nav = static::where('location', $location)->first();
            return $nav?->items ?? [];
        });
    }

    /**
     * Met à jour les éléments de navigation d'un emplacement.
     */
    public static function setItems(string $location, array $items): void
    {
        static::updateOrCreate(
            ['location' => $location],
            ['items' => $items]
        );
        Cache::forget("nav_{$location}");
    }
}
