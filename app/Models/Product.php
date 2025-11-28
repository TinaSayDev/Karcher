<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Product extends Model
{
    protected $fillable = [
        'category_id',
        'slug',
        'price',
        'is_hit',
        'is_recommended',
        'is_new',
        'is_discounted',
    ];

    // Категория продукта
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    // Переводы продукта
    public function translations(): HasMany
    {
        return $this->hasMany(ProductTranslation::class);
    }

    // Удобные методы для меток
    public function isHit(): bool { return $this->is_hit; }
    public function isRecommended(): bool { return $this->is_recommended; }
    public function isNew(): bool { return $this->is_new; }
    public function isDiscounted(): bool { return $this->is_discounted; }
}
