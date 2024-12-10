<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ColorProductResourse extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "id"=> $this->color->id,
            "name"=> $this->color->name,
            'color_code'=>$this->color->id,
            'have_front_image'=>$this->front_image ?true : false,
            'have_back_image'=>$this->back_image ?true : false,
            'front_image'=>$this->front_image != null  ? asset('uploads/'.$this->front_image)  : null,
            'back_image'=>$this->back_image != null  ? asset('uploads/'.$this->back_image)  : null,
            'price'=>(floatval($this->price)) ? floatval($this->price) :0,
        ];
    }
}
