<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $fillable = ['slug','image','is_published','published_at'];

    public function translations() {
        return $this->hasMany(PostTranslation::class);
    }

    public function translation($locale = null) {
        $locale = $locale ?? app()->getLocale();
        return $this->translations->where('locale',$locale)->first();
    }

}
