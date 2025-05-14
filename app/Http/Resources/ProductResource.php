<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray($request)
    {
        return [
            "id" => $this->id,
            "image" => $this->image,
            "icon" => $this->icon,
            "price" => $this->price,
            "price_bd" => $this->price_bd,
            "title" => $this->title,
            "brand" => $this->brand,
            "subtitle" => $this->subtitle,
            "description" => $this->description,
            "generation" => $this->generation,
            "processor" => $this->processor,
            "ram" => $this->ram,
            "screenCard" => $this->screenCard,
            "ssd" => $this->ssd,
            "hdd" => $this->hdd,
        ];
    }
}
