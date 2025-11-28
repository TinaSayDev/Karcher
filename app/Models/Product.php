<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Product extends Model
{
    protected $fillable = [
        'category_id',
        'code',
        'price_old',
        'price_new',
        'image_main',
        'images',
        'catalog_images',
        'specifications',
        'equipment',
        'is_hit',
        'is_new',
        'is_recommended',
        'is_sale',
    ];

    protected $casts = [
        'images' => 'array',
        'catalog_images' => 'array',
        'specifications' => 'array',
        'equipment' => 'array',
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
