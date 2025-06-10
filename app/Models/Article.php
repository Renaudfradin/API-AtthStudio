<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Article extends Model
{
    use HasFactory;

    public const MORPH_TYPE = 'Article';

    protected $fillable = [
        'title',
        'slug',
        'content',
        'active',
        'category_id',
        'image',
        'time_read',
    ];

    public function documents()
    {
        return $this->morphMany(Document::class, 'documentable');
    }

    public function categorie(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function scopeActive($query)
    {
        return $query->where('active', true);
    }
}
