<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    public function toArray($request)
    {

        $locale = app()->getLocale();
        $translation = $this->translation($locale);

        return [
            'id' => $this->id,
            'name' => $translation->name ?? $this->name,
            'description' => $translation->description ?? $this->description,
            'price' => $this->price_new,
            'images' => $this->images,
            'image_main'=>$this->image_main,
            'is_hit' => $this->is_hit,
        ];

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
