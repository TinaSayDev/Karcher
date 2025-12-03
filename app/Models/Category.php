<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Category extends Model
{
    protected $fillable = [
        'parent_id',
        'image',
    ];

    // Все переводы
    public function translations() {
        return $this->hasMany(CategoryTranslation::class, 'category_id');
    }

    // Один перевод для текущего locale
    public function translation() {
        return $this->hasOne(CategoryTranslation::class, 'category_id')
            ->where('locale', app()->getLocale());
    }

    // Дочерние категории
    public function children() {
        return $this->hasMany(Category::class, 'parent_id');
    }

    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }

}
