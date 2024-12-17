<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductShortDataResourse extends JsonResource
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
            'title'=>$this->name,
            'image'=> $this->image,  
            'slug'=>$this->slug,
            '3d_show'=>route('viwer',$this->id),
            'url'=>route('get_single_product',$this->slug),   
        ];
    }
}
