<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\AboutPageTranslation;

class AboutPage extends Model
{
    public function translations()
    {
        return $this->hasMany(AboutPageTranslation::class);
    }

    public function translation($locale = null)
    {
        $locale = $locale ?? app()->getLocale();

        return $this->translations()
                ->where('locale', $locale)
                ->first()
            ?? $this->translations()->where('locale', 'ru')->first();
    }
}
