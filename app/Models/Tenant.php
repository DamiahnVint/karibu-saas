<?php

namespace App\Models;

use App\Enums\TenantPlan;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tenant extends Model
{
    use SoftDeletes;

    protected $table = 'tenants';

    protected $fillable = [
        'name',
        'slug',
        'domain',
        'plan',
        'plan_expires_at',
        'is_active',
        'max_employees',
        'settings',
        'metadata',
        'subscription_status',
        'trial_ends_at',
        'subscription_ends_at',
        'last_payment_at',
    ];

    protected $casts = [
        'plan' => TenantPlan::class,
        'plan_expires_at' => 'datetime',
        'is_active' => 'boolean',
        'max_employees' => 'integer',
        'settings' => 'array',
        'metadata' => 'array',
        'trial_ends_at' => 'datetime',
        'subscription_ends_at' => 'datetime',
        'last_payment_at' => 'datetime',
    ];

    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }

    public function employees(): HasMany
    {
        return $this->hasMany(Employee::class);
    }

    public function payslips(): HasMany
    {
        return $this->hasMany(Payslip::class);
    }

    public function planModel(): BelongsTo
    {
        return $this->belongsTo(Plan::class, 'plan_id');
    }

    public function subscription(): HasOne
    {
        return $this->hasOne(Subscription::class)->latestOfMany();
    }

    public function activeSubscription(): HasOne
    {
        return $this->hasOne(Subscription::class)->where('status', 'active')->latestOfMany();
    }

    public function subscriptions(): HasMany
    {
        return $this->hasMany(Subscription::class);
    }

    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class);
    }

    public function isActive(): bool
    {
        if (!$this->is_active) {
            return false;
        }

        if ($this->subscription_status === 'active') {
            return true;
        }

        if ($this->subscription_status === 'trialing' && $this->trial_ends_at?->isFuture()) {
            return true;
        }

        return false;
    }

    public function isTrialing(): bool
    {
        return $this->subscription_status === 'trialing'
            && $this->trial_ends_at?->isFuture();
    }

    public function hasAccess(): bool
    {
        return $this->isActive() || $this->isTrialing();
    }

    public function isPlanValid(): bool
    {
        if ($this->plan === TenantPlan::FREE) {
            return $this->plan_expires_at === null || $this->plan_expires_at->isFuture();
        }
        return true;
    }

    public function canAddEmployee(): bool
    {
        return $this->employees()->count() < $this->max_employees;
    }

    public function trialDaysRemaining(): int
    {
        if (!$this->isTrialing()) {
            return 0;
        }

        return max(0, now()->diffInDays($this->trial_ends_at, false));
    }

    public static function findByDomain(string $domain): ?static
    {
        return static::where('domain', $domain)->first();
    }

    public static function findBySlug(string $slug): ?static
    {
        return static::where('slug', $slug)->first();
    }
}
