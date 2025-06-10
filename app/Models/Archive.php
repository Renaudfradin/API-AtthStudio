<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Archive extends Model
{
    use HasFactory;

    public const MORPH_TYPE = 'Archive';

    protected $fillable = [
        'title',
        'slug',
        'content',
        'active',
        'image',
    ];

    protected $casts = [
        'active' => 'boolean',
    ];

    public function documents()
    {
        return $this->morphMany(Document::class, 'documentable');
    }

    public function scopeActive($query)
    {
        return $query->where('active', true);
    }
}
