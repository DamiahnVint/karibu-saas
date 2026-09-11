<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CmsFormSubmission extends Model
{
    protected $table = 'cms_form_submissions';

    protected $fillable = [
        'form_type',
        'data',
        'ip_address',
        'is_read',
    ];

    protected $casts = [
        'data' => 'array',
        'is_read' => 'boolean',
    ];

    public function scopeUnread($query)
    {
        return $query->where('is_read', false);
    }

    public function scopeForType($query, string $type)
    {
        return $query->where('form_type', $type);
    }

    public function markAsRead(): void
    {
        $this->update(['is_read' => true]);
    }
}
