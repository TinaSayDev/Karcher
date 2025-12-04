<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    public function toArray($request)
    {

        // Перевод на текущей локали
        $t = $this->translations
            ->where('locale', app()->getLocale())
            ->first();

        return [
            'id' => $this->id,
            'category_id' => $this->category_id,
            'code' => $this->code,
            'price_old' => $this->price_old,
            'price' => $this->price_new,
            'image_main' => $this->image_main,
            'images' => $this->images,

            'name' => $t->name ?? $this->name,
            'tabs' => $t->tabs ?? [
                    'description' => '',
                    'specifications' => '',
                    'equipment' => ''
                ],
            'slug' => $t->slug ?? '',
            'short_description' => $t->short_description ?? '',


            'category' => [
                'id' => $this->category->id ?? null,
                'name' => $this->category?->translations
                        ->where('locale', app()->getLocale())
                        ->first()?->name ?? null,
            ],

            'is_hit' => $this->is_hit,
            'is_new' => $this->is_new,
            'is_recommended' => $this->is_recommended,
            'is_sale' => $this->is_sale,
        ];
        /*return [
            'id' => $this->id,
            'name' => $translation->name ?? $this->name,
            'description' => $translation->description ?? $this->description,
            'price' => $this->price_new,
            'images' => $this->images,
            'image_main'=>$this->image_main,
            'is_hit' => $this->is_hit,
            'category_id' => $this->category_id,
            'code' => $this->code,
            'price_old' => $this->price_old,
            'slug' => $translation->slug ?? '',
            'short_description' => $translation->short_description ?? '',
            'specifications' => $translation->specifications ?? '',
            'equipment' => $translation->equipment ?? '',
            'category' => [
                'id' => $this->category_id,
                'name' => optional($this->category?->translations
                        ->where('locale', app()->getLocale())
                        ->first()
                    )->name ?? '',
            ],

        ];*/

        /*$translation = $this->translations->first();

        return [
            'id' => $this->id,
            'slug' => $this->slug,
            'name' => $translation?->name,
            'description' => $translation?->description,
            'price' => $this->price,
            'images' => $this->images->pluck('url'),
        ];*/
    }
}
