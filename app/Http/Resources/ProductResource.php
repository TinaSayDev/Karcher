<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id'    => $this->id,
            'name'  => $this->translation->name ?? $this->name ?? 'Название отсутствует',
            'price' => $this->price,
            'image_main' => $this->image_main ?? null,
            'images'=>$this->images ??  $this->image_main
        ];
    }
}
