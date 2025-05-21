<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'active',
    ];

    public function articles(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
}
