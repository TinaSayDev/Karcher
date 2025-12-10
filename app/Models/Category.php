<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Category extends Model
{
    protected $fillable = ['parent_id', 'image'];

    // все переводы
    public function translations(): HasMany
    {
        return $this->hasMany(CategoryTranslation::class, 'category_id');
    }

    // перевод под текущий locale
    public function translation($locale = null)
    {
        $locale = $locale ?? app()->getLocale();
        return $this->translations->where('locale',$locale)->first();
    }

    public function getNameRuAttribute()
    {
        return $this->translations()
            ->where('locale', 'ru')
            ->value('name');
    }

    // дочерние категории
    public function children(): HasMany
    {
        return $this->hasMany(Category::class, 'parent_id');
    }

    // родительская категория
    public function parent(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    // уровень вложенности
    public function getLevelAttribute(): int
    {
        $level = 0;
        $parent = $this->parent;
        while ($parent) {
            $level++;
            $parent = $parent->parent;
        }
        return $level;
    }

    // русское название (для таблиц/админки)
    public function getRuNameAttribute()
    {
        return optional($this->translation('ru'))->name;
    }

    // продукты категории
    public function products(): HasMany
    {
        return $this->hasMany(\App\Models\Product::class, 'category_id');
    }
}
