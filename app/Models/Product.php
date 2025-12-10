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
        'is_hit',
        'is_new',
        'is_recommended',
        'is_sale',
    ];

    protected $casts = [
        'images' => 'array',
        'catalog_images' => 'array',
        'is_hit' => 'boolean',
        'is_new' => 'boolean',
        'is_recommended' => 'boolean',
        'is_sale' => 'boolean',
    ];


    public function translations()
    {
        return $this->hasMany(ProductTranslation::class);
    }

    // перевод под текущий locale
    public function translation($locale = null)
    {
        $locale = $locale ?? app()->getLocale();
        return $this->translations->where('locale',$locale)->first();
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }



    // Удобные методы для меток
    public function isHit(): bool { return $this->is_hit; }
    public function isRecommended(): bool { return $this->is_recommended; }
    public function isNew(): bool { return $this->is_new; }
    public function isDiscounted(): bool { return $this->is_discounted; }
}
