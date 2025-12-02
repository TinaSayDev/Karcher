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

    public function translations()
    {
        return $this->hasMany(ProductTranslation::class);
    }

    // текущее активное на выбранной локали
    public function translation($locale = null)
    {
        $locale = $locale ?? app()->getLocale();

        return $this->translations()
                ->where('locale', $locale)
                ->first()
            ?? $this->translations()->where('locale', 'ru')->first();
    }


    // Удобные методы для меток
    public function isHit(): bool { return $this->is_hit; }
    public function isRecommended(): bool { return $this->is_recommended; }
    public function isNew(): bool { return $this->is_new; }
    public function isDiscounted(): bool { return $this->is_discounted; }
}
