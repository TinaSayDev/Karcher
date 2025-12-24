<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PageTranslation extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'page_id',
        'locale',
        'title',
        'h1',
        'excerpt',
        'content',
        'tags',

        // SEO
        'meta_title',
        'meta_description',
        'meta_keywords',
        'og_title',
        'og_description',
        'og_image',
    ];

    protected $casts = [
        'tags' => 'array', // если будешь хранить JSON
    ];

    /**
     * Связь с основной страницей
     */
    public function page()
    {
        return $this->belongsTo(Page::class);
    }
}
