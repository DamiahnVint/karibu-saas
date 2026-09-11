<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class CmsSetting extends Model
{
    protected $table = 'cms_settings';

    protected $fillable = [
        'group',
        'key',
        'value',
        'type',
    ];

    /**
     * Récupère une valeur de paramètre par sa clé.
     * Utilise le cache Redis (30 min) pour les performances.
     */
    public static function getValue(string $key, mixed $default = null): mixed
    {
        return Cache::remember("setting_{$key}", 1800, function () use ($key, $default) {
            $setting = static::where('key', $key)->first();
            return $setting?->value ?? $default;
        });
    }

    /**
     * Définit ou met à jour une valeur de paramètre.
     */
    public static function setValue(string $key, mixed $value, string $group = 'general', string $type = 'text'): void
    {
        static::updateOrCreate(
            ['key' => $key],
            ['value' => $value, 'group' => $group, 'type' => $type]
        );
        Cache::forget("setting_{$key}");
    }

    /**
     * Récupère tous les paramètres d'un groupe donné.
     */
    public static function getGroup(string $group): array
    {
        return static::where('group', $group)
            ->get()
            ->pluck('value', 'key')
            ->toArray();
    }

    /**
     * Invalide le cache de tous les paramètres.
     */
    public static function flushCache(): void
    {
        static::all()->each(function ($setting) {
            Cache::forget("setting_{$setting->key}");
        });
    }
}
