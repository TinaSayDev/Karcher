<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class MenuItem extends Model
{
    protected $fillable = [
        'menu_id',
        'parent_id',
        'title',
        'type',
        'linkable_id',
        'linkable_type',
        'url',
        'sort',
        'is_active',
    ];

    protected $casts = [
        'title' => 'array',
        'is_active' => 'boolean',
    ];

    public function menu()
    {
        return $this->belongsTo(Menu::class);
    }

    public function parent()
    {
        return $this->belongsTo(self::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(self::class, 'parent_id')->orderBy('sort');
    }

    public function linkable()
    {
        return $this->morphTo();
    }

    public function getLinkAttribute()
    {
        return match ($this->type) {
            'page'     => route('page.show', $this->linkable?->slug),
            'category' => route('category.show', $this->linkable?->slug),
            'url'      => $this->url,
            default    => '#',
        };
    }
}
