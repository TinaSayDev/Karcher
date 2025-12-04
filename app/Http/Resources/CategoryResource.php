<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

/*class CategoryResource extends JsonResource
{
    public function toArray($request)
    {
        // Берём перевод ровно под текущий язык
        $translation = $this->translations
            ->where('locale', app()->getLocale())
            ->first();

        return [
            'id'        => $this->id,
            'parent_id' => $this->parent_id,
            'image'     => $this->image,

            'name'      => $translation->name ?? '',
            'slug'      => $translation->slug ?? '',
        ];


    }
}*/

class CategoryResource extends JsonResource
{
    public function toArray($request)
    {
        // Берём перевод под текущий язык
        $translation = $this->translations
            ->where('locale', app()->getLocale())
            ->first();

        return [
            'id' => $this->id,
            'parent_id' => $this->parent_id,
            'image' => $this->image,
            'name' => $translation->name ?? '',
            'slug' => $translation->slug ?? '',
            'description' => $translation->description ?? '',

            // дети категории
            'children' => CategoryResource::collection($this->whenLoaded('children')),

            // продукты категории (только для листовых)
            'products' => $this->whenLoaded('products', function () {
                return \App\Http\Resources\ProductResource::collection($this->products);
            }),
        ];
    }
}
