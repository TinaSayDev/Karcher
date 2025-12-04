<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductTranslation extends Model
{
    protected $fillable = [
        'product_id',
        'locale',
        'name',
        'slug',
        'short_description'
    ];

    protected $casts = [
        'tabs' => 'array',
    ];


    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}
