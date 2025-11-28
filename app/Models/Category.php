<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Category extends Model
{
    protected $fillable = [
        'parent_id',
        'type',
        'slug',
    ];

    // Родительская категория
    public function parent(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    // Дочерние категории
    public function children(): HasMany
    {
        return $this->hasMany(Category::class, 'parent_id');
    }

    // Переводы категории
    public function translations(): HasMany
    {
        return $this->hasMany(CategoryTranslation::class);
    }

    // Продукты этой категории
    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }
}
