<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Plan extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'description',
        'price',
        'currency',
        'billing_cycle',
        'max_employees',
        'features',
        'is_active',
        'is_trial',
        'trial_days',
        'sort_order',
    ];

    protected $casts = [
        'features' => 'array',
        'is_active' => 'boolean',
        'is_trial' => 'boolean',
        'price' => 'integer',
        'max_employees' => 'integer',
        'trial_days' => 'integer',
        'sort_order' => 'integer',
    ];

    public function subscriptions(): HasMany
    {
        return $this->hasMany(Subscription::class);
    }

    public function getFormattedPriceAttribute(): string
    {
        if ($this->price === 0) {
            return 'Sur mesure';
        }

        return number_format($this->price, 0, ',', ' ') . ' ' . $this->currency;
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopePublic($query)
    {
        return $query->where('is_active', true)->where('is_trial', false)->orderBy('sort_order');
    }

    public function scopeForPricing($query)
    {
        return $query->where('is_active', true)->where('is_trial', false)->orderBy('sort_order');
    }
}
