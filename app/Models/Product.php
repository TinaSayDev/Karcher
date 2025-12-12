<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

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

        return $this->translations
                ->where('locale', $locale)
                ->first()
            ?? $this->translations->where('locale', 'ru')->first();
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /*
     |--------------------------------------------------------------------------
     | Slug generation
     |--------------------------------------------------------------------------
     */
    protected static function boot()
    {
        parent::boot();

        // Автогенерация slug после создания продукта
        static::created(function (Product $product) {
            foreach ($product->translations as $translation) {
                if (empty($translation->slug)) {
                    $translation->slug = str($translation->name)->slug();
                    $translation->save();
                }
            }
        });

        // После сохранения — переместить картинки в папку по ID продукта
        static::saved(function (Product $product) {
            $product->moveFilesToProductFolder();
        });
    }

    /*
     |--------------------------------------------------------------------------
     | File management
     |--------------------------------------------------------------------------
     */
    public function moveFilesToProductFolder()
    {
        $folder = "products/{$this->id}";

        if ($this->image_main && str_starts_with($this->image_main, 'temp/')) {
            $filename = basename($this->image_main);
            $newPath = "{$folder}/{$filename}";
            Storage::disk('public')->move($this->image_main, $newPath);
            $this->image_main = $newPath;
            $this->saveQuietly();
        }

        if (is_array($this->images)) {
            $newImages = [];
            foreach ($this->images as $img) {
                if (str_starts_with($img, 'temp/')) {
                    $filename = basename($img);
                    $newPath = "{$folder}/{$filename}";
                    Storage::disk('public')->move($img, $newPath);
                    $newImages[] = $newPath;
                } else {
                    $newImages[] = $img;
                }
            }
            $this->images = $newImages;
            $this->saveQuietly();
        }
    }



    // Удобные методы для меток
    public function isHit(): bool { return $this->is_hit; }
    public function isRecommended(): bool { return $this->is_recommended; }
    public function isNew(): bool { return $this->is_new; }
    public function isDiscounted(): bool { return $this->is_discounted; }
}
