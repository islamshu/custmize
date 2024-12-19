<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderDetilesResourse extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'=>$this->id,
            'product'=>new ProducOrderResourse($this->product),
            'color'=>new ColorResourse($this->color),
            'size'=>new SizeProductResourse($this->size),
            'postal_code'=>$this->postal_code,
            'country'=>$this->country,
            'status'=>$this->status,
            'quantity'=>$this->quantity,
            'price_without_size_color'=>$this->price_without_size_color,
            'price_for_size_color'=>$this->price_for_size_color,
            'full_price'=>$this->full_price,
            'front_image'=>asset('storage/'.$this->front_image),
            'back_image'=>$this->back_image != null ? asset('storage/'.$this->back_image) : null,

        ];
    }
}
