<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CmsMedia extends Model
{
    use SoftDeletes;

    protected $table = 'cms_media';

    protected $fillable = [
        'name',
        'file_path',
        'file_type',
        'file_size',
        'alt_text',
        'category',
    ];

    protected $casts = [
        'file_size' => 'integer',
    ];

    public function getUrlAttribute(): string
    {
        return '/storage/' . $this->file_path;
    }

    public function scopeCategory($query, string $category)
    {
        return $query->where('category', $category);
    }
}
