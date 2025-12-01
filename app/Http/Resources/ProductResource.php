<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    public function toArray($request)
    {

        $tr = $this->translation;

        return [
            'id' => $this->id,
            'slug' => $this->slug,
            'price' => $this->price_new,
            'name' => $tr->name ?? '',
            'description' => $tr->description ?? '',
            'images'=>$this->images ??  $this->image_main
        ];
//        return [
//            'id'    => $this->id,
//            'name'  => $this->translation->name ?? $this->name ?? 'Название отсутствует',
//            'price' => $this->price,
//            'image_main' => $this->image_main ?? null,
//            'images'=>$this->images ??  $this->image_main
//        ];
    }
}
