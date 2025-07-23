<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    public const MORPH_TYPE = 'Project';

    protected $fillable = [
        'title',
        'title_home',
        'slug',
        'content',
        'active',
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
