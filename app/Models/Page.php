<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    protected $fillable = [
        'slug',
        'is_published',
        'publish_date',
        'is_menu',
        'menu_id',
        'meta_robots',
        'canonical_url',
    ];

    public function translations()
    {
        return $this->hasMany(PageTranslation::class);
    }

    public function translation()
    {
        return $this->hasOne(PageTranslation::class)
            ->where('locale', app()->getLocale());
    }
}
