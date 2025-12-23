<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $fillable = ['slug','image','is_published','is_promote', 'published_at'];
    public $timestamps = false;
    protected $casts = [
        'published_at' => 'datetime',
    ];
    public function translations() {
        return $this->hasMany(PostTranslation::class);
    }

    public function translation($locale = null) {
        $locale = $locale ?? app()->getLocale();
        return $this->translations->where('locale',$locale)->first();
    }

}
