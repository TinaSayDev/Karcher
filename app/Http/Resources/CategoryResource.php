<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Log;

class CategoryResource extends JsonResource
{
    public function toArray($request)
    {
        $locale = app()->getLocale();

        $translation = $this->translations->firstWhere('locale', $locale);

        return [
            'id' => $this->id,
            'parent_id' => $this->parent_id,
            'image' => $this->image,
            'name' => $translation->name ?? '',
            'slug' => $translation->slug ?? '',
            'description' => $translation->description ?? '',

            'children' => CategoryResource::collection($this->whenLoaded('children')),
            'products' => $this->whenLoaded('products', function () {
                return \App\Http\Resources\ProductResource::collection($this->products);
            }),
        ];
    }
}
