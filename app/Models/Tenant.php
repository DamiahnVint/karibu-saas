<?php

namespace App\Models;

use App\Enums\TenantPlan;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
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
    ];

    protected $casts = [
        'plan' => TenantPlan::class,
        'plan_expires_at' => 'datetime',
        'is_active' => 'boolean',
        'max_employees' => 'integer',
        'settings' => 'array',
        'metadata' => 'array',
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

    public function isActive(): bool
    {
        return $this->is_active
            && ($this->plan_expires_at === null || $this->plan_expires_at->isFuture());
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

    public static function findByDomain(string $domain): ?static
    {
        return static::where('domain', $domain)->first();
    }

    public static function findBySlug(string $slug): ?static
    {
        return static::where('slug', $slug)->first();
    }
}
