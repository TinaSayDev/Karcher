<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    protected $fillable = ['key'];

    public function translations()
    {
        return $this->hasMany(ContactTranslation::class);
    }

    public function translation($locale = null)
    {
        $locale = $locale ?? app()->getLocale();

        return $this->translations
                ->where('locale', $locale)
                ->first()
            ?? $this->translations->where('locale', 'ru')->first();
    }
}

