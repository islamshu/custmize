<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ColorResourse extends JsonResource
{
    
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "id" => $this->id, // ID اللون
            "name" => $this->name, // اسم اللون
            "color_code" => $this->code, // كود اللون
            'price' => (floatval($this->pivot->price)) ? floatval($this->pivot->price) : 0, // السعر من الجدول الوسيط
        ];
    }
}
