<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    protected $locale;

    public function __construct($resource, $locale = null)
    {
        parent::__construct($resource);
        $this->locale = $locale ?? app()->getLocale();
    }

    public function toArray($request)
    {
        $t = $this->translations
                ->where('locale', $this->locale)
                ->first()
            ?? $this->translations->where('locale', 'ru')->first();

        return [
            'id' => $this->id,
            'category_id' => $this->category_id,
            'code' => $this->code,
            'price_old' => $this->price_old,
            'price_new' => $this->price_new,
            'image_main' => $this->image_main,
            'images' => $this->images ?? [],

            'name' => $t->name ?? '',
            'slug' => $t->slug ?? '',
            'short_description' => $t->short_description ?? '',
            'description'=>$t->description ?? '',
            'specifications'=>$t->specifications ?? '',
            'equipment'=>$t->equipment ?? '',

            'category' => $this->category ? [
                'id' => $this->category->id,
                'name' => $this->category->translations
                        ->where('locale', $this->locale)
                        ->first()?->name
                    ?? $this->category->translations->where('locale', 'ru')->first()?->name
                    ?? '',
                'slug' => $this->category->translations
                        ->where('locale', $this->locale)
                        ->first()?->slug
                    ?? $this->category->translations->where('locale', 'ru')->first()?->slug
                    ?? '',
                'products' => $this->category->products->map(fn($p) => [
                    'id' => $p->id,
                    'slug' => $p->translations
                            ->where('locale', $this->locale)
                            ->first()?->slug
                        ?? $p->translations->where('locale', 'ru')->first()?->slug
                        ?? '',
                    'name' => $p->translations
                            ->where('locale', $this->locale)
                            ->first()?->name
                        ?? $p->translations->where('locale', 'ru')->first()?->name
                        ?? '',
                    'price' => $p->price_new,
                    'image_main' => $p->image_main,
                ])
            ] : null,

            'is_hit' => $this->is_hit,
            'is_new' => $this->is_new,
            'is_recommended' => $this->is_recommended,
            'is_sale' => $this->is_sale,
        ];
    }
}
